<?php
namespace App\Http\Controllers;

use App\Http\Requests\LeadFormRequest;
use App\Models\Lead;
use Illuminate\Http\Response;

/**
 * Контроллер для работы с лидами в Битрикс24.
 * @package App\Http\Controllers
 */
class LeadController extends Controller
{
    /**
     * Маршрут для обработки отправки формы и создания лидов в Битрикс24.
     *
     * @route POST /form-submit
     *
     * @param LeadFormRequest $request
     * @return Response
     */
    public function processForm(LeadFormRequest $request)
    {

        $leadData = $request->validated();

        return $this->createLeadInBitrix24($leadData);
    }

    /**
     * Метод для сохранения информации о лидах в базе данных.
     *
     * @param array $leadData
     * @return Lead|null
     */
    private function saveLeadToDatabase(array $leadData): ?object
    {
        return Lead::Create($leadData);
    }

    /**
     * Метод для создания контактов и лида в Битрикс24.
     *
     * @param array $leadData
     * @return array
     */
    private function createLeadInBitrix24(array $leadData): array
    {

        $queryData = http_build_query(array(
            'fields' => [
                'NAME' => $leadData['firstname'],
                'LAST_NAME' => $leadData['lastname'],
                'SECOND_NAME' => $leadData['surname'],
                'PHONE' => [['VALUE' => $leadData['phone'], 'VALUE_TYPE' => 'WORK']],
                'EMAIL' => [['VALUE' => $leadData['email'], 'VALUE_TYPE' => 'WORK']],
                'COMMENTS' => $leadData['comment'],
                'BIRTHDATE' => $leadData['birthday'],
            ],
            'params' => ['REGISTER_SONET_EVENT' => 'Y'],
        ));

        $bitrixLeadUrl = config('bitrix.bitrix_24_lead_url');
        $bitrixRest = config('bitrix.bitrix_24_rest');
        $bitrixApiCode = config('bitrix.bitrix_24_api_code');

        $queryUrl = "{$bitrixLeadUrl}/{$bitrixRest}/{$bitrixApiCode}/crm.lead.add.json";
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $queryUrl,
            CURLOPT_POSTFIELDS => $queryData,
        ));

        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, 1);

        if (!array_key_exists('error', $result)) {
            $leadId = $result['result'];
            $leadLink = "{$bitrixLeadUrl}/crm/lead/show/" . $leadId . '/';

            $leadData['link'] = $leadLink;
            $leadData['bitrix_lead_id'] = $leadId;
        }

        if (isset($leadLink)) {
            $message = "Новый лид создан:\n\n" .
                "Имя: {$leadData['firstname']}\n" .
                "Фамилия: {$leadData['lastname']}\n" .
                "Отчество: {$leadData['surname']}\n" .
                "Телефон: {$leadData['phone']}\n" .
                "Email: {$leadData['email']}\n" .
                "Комментарий: {$leadData['comment']}\n\n" .
                "Ссылка на лид: {$leadLink}";

            $this->saveLeadToDatabase($leadData);

            $data['success'] = 1;
        } else {
            $message = "Ошибка при создании лида:\n\n" .
                "Имя: {$leadData['firstname']}\n" .
                "Фамилия: {$leadData['lastname']}\n" .
                "Отчество: {$leadData['surname']}\n" .
                "Телефон: {$leadData['phone']}\n" .
                "Email: {$leadData['email']}\n" .
                "Комментарий: {$leadData['comment']}\n";
            "Error: {$result['error_description']}\n";

            $data['success'] = 0;
        }

        $telegramMessageSent = $this->sendTelegramMessage($message);
        return $data;
    }

    /**
     * Метод для отправки сообщения в Telegram канал.
     *
     * @param string $message
     * @return bool
     */
    private function sendTelegramMessage(string $message): bool
    {
        $telegramBotToken = config('telegram.telegram_bitrix_24_token');
        $chatId = config('telegram.telegram_bitrix_24_chat');


        $url = "https://api.telegram.org/bot{$telegramBotToken}/sendMessage?chat_id={$chatId}&parse_mode=html&text=" . urlencode($message);

        $response = file_get_contents($url);
        $response = json_decode($response, true);

        return ($response['ok'] === true);
    }

}
