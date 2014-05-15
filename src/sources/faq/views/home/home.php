<div class="jumbotron">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Добро пожаловать!</h1>
                <p>В автоматизированную систему расчёта рейтинга профессорско-преподавательского состава.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <form class="form" role="form">
                    <?= hidden_field('controller', 'teachers')?>
                    <?= hidden_field('action', 'index')?>
                    <div class="form-group">
                        <label class="sr-only" for="teacher-search">Имя/Фамилия преподавателя</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                            <input id="teacher-search" type="text" name="search" class="input-lg form-control" placeholder="ФИО преподавателя"/>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default btn-lg">Поиск</button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p><a class="btn btn-primary btn-lg" href='/?controller=home&action=help' role="button">Перейти к справке »</a></p>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <!-- Example row of columns -->
    <div class="row">
        <div class="col-md-4">
            <h2>Общий рейтинг</h2>
            <p>Позволяет провести анализ состояния рейтинга всех преподавателей на текущий момент времени (генерация может занять длительное время).</p>
            <p><a class="btn btn-default" href='/?controller=teachers&action=total_rating' role="button">Перейти »</a></p>
        </div>
        <div class="col-md-4">
            <h2>Преподаватели</h2>
            <p>В этом разделе можно найти преподавателя по его имени / фамилии, произвести расчёт рейтинга и вывести отчёт на печать.</p>
            <p><a class="btn btn-default" href='/?controller=teachers&action=index' role="button">Перейти »</a></p>
        </div>
        <div class="col-md-4">
            <h2>Помощь</h2>
            <p>Здесь вы можете ознакомиться с деталями работы системы и найти ответы на вопросы.</p>
            <p><a class="btn btn-default" href='/?controller=home&action=help' role="button">Перейти »</a></p>
        </div>
    </div>

    <hr>

    <footer>
        <p>Систему разработал студент факультета информатики Ишков Дмитрий в рамках дипломного проектирования в 2014 году.</p>
    </footer>
</div>
<script>
    $( "#teacher-search" ).autocomplete({
        minLength: 3,
        source: <?=json_encode($teacher_names)?>
    });
</script>
