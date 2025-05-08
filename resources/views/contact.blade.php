@extends('layouts.app')
@section('content')
<style>
  .text-danger {
    color: red
  }
  </style>
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="contact-us container">
      <div class="mw-930">
        <h2 class="page-title">СВЯЖИТЕСЬ С НАМИ</h2>
      </div>
    </section>

    <hr class="mt-2 text-secondary " />
    <div class="mb-4 pb-4"></div>

    <section class="contact-us container">
      <div class="mw-930">
        <div class="contact-us__form">
            @if(@Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{Session::get('success')}}
            </div>
            @endif
          <form name="contact-us-form" class="needs-validation" novalidate="" action="{{route('home.contact.store')}}" method="POST">
            @csrf
            <h3 class="mb-5">Свяжитесь с нами</h3>
            <div class="form-floating my-4">
              <input type="text" class="form-control" name="name" placeholder="Имя *" value="{{old('name')}}" required="">
              <label for="contact_us_name">ФИО *</label>
              @error('name')
              <span style="color: red;">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-floating my-4">
              <input type="text" class="form-control" name="phone" placeholder="Телефон *" value="{{old('phone')}}" required="">
              <label for="contact_us_name">Телефон *</label>
              @error('phone')
                  <span style="color: red;">{{ $message }}</span>
              @enderror

            </div>
            <div class="form-floating my-4">
              <input type="email" class="form-control" name="email" placeholder="Адрес электронной почты *" value="{{old('email')}}" required="">
              <label for="contact_us_name">Адрес электронной почты *</label>
              @error('email')
              <span style="color: red;">{{ $message }}</span>
               @enderror
            </div>
            <div class="my-4">
              <textarea class="form-control form-control_gray" name="comment" placeholder="Ваше сообщение"  cols="30"
                rows="8" required="">{{old('comment')}}</textarea>
              @error('comment')
              <span style="color: red;">{{ $message }}</span>
              @enderror
            </div>
            <div class="my-4">
              <button type="submit" class="btn btn-primary">Отправить</button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>


@endsection
