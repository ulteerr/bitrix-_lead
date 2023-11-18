@extends('layouts.base')
@section('title')
@endsection
@section('content')
    <section class="main mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <form class="col-12 col-md-9 col-lg-6 p-md-5" action="{{ route('lead-form') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Фамилия*</label>
                        <input type="text" name="lastname" class="form-control" placeholder="Иванов" required
                            value="{{ old('lastname') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Имя*</label>
                        <input type="text" name="firstname" class="form-control" placeholder="Иван" required
                            value="{{ old('firstname') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Отчество*</label>
                        <input type="text" name="surname" class="form-control" placeholder="Иваныч" required
                            value="{{ old('surname') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Дата Рождения*</label>
                        <input type="text" class="form-control" name="birthday" data-name="birthday" required
                            value="{{ old('birthday') }}" placeholder="01.01.1950">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Телефон*</label>
                        <input type="text" name="phone" data-name="phone" class="form-control"
                            placeholder="+7 (921) 443-33-22" required value="{{ old('phone') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Почта*</label>
                        <input type="email" name="email" class="form-control" placeholder="example@mail.ru" required
                            value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Комментарий*</label>
                        <textarea name="comment" class="form-control"cols="30" rows="10" required placeholder="Оставьте комментарий"
                            value="{{ old('comment') }}"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Отправить</button>
                </form>
            </div>
        </div>
    </section>
@endsection
