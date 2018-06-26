@extends('layouts.app')

@section('content')


<?php

if (isset($_POST['adduser'])) {
    DB::table('worker')->insert([
              ['name' => $_POST['name'],
              'surname' => $_POST['surname'],
              'patronymic' => $_POST['patronymic']]
              ]);

        $message = 1;
}?>

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

           <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title float-left">Web ГИС предприятия по вывозу мусора</h4>
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="home">Главная</a></li>
                            <li class="breadcrumb-item active">Добавить сотрудника</li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
                                <?php
                if (isset($message)) {
                    echo '<div class="alert alert-custom alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            Сотрудник добавлен       
                            </div>';
                }
                ?>

            </div>

            <div class="row">
                       <div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="header-title m-t-0">Добавление новго сотрудника</h4>
                                    <p class="text-muted font-14 m-b-20">
                                        На данной странице необходимо добавить нового сотрудника. Заполните его персональные данные,.
                                    </p>

                                    <form  method="POST">
                                        {{ csrf_field() }}

                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-4 col-form-label">Фамилия<span class="text-danger">*</span></label>
                                            <div class="col-7">
                                                <input type="text" required parsley-type="email" class="form-control"
                                                       id="inputEmail3" name="surname" placeholder="Иванов">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-4 col-form-label">Имя<span class="text-danger">*</span></label>
                                            <div class="col-7">
                                                <input type="text" required parsley-type="email" class="form-control"
                                                       id="inputEmail3" name="name" placeholder="Иван">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-4 col-form-label">Отчёство<span class="text-danger">*</span></label>
                                            <div class="col-7">
                                                <input type="text" required parsley-type="email" class="form-control"
                                                       id="inputEmail3" name="patronymic" placeholder="Иванович">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-8 offset-4">
                                                <button type="submit" name="adduser" class="btn btn-gradient waves-effect waves-light">
                                                    Добавить
                                                </button>
                                                <button type="reset"
                                                        class="btn btn-light waves-effect m-l-5">
                                                    Очистить
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div> <!-- end col -->    
                        </div>
        </div>
    </div>
</div>
@endsection
