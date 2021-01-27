ИНИЦИАЛИЗАЦИЯ ПРОЕКТА
1. Создать .env.local файл по примеру .env
2. Запустить ./initiate_project.sh (если будут проблеммы при запуске, можно выполнить комманды из скрипта вручную по отдельности)
3. Опционально, запустить PHP-Unit тесты из под докера (./bin/phpunit в swivl_php контейнере)

Если нужно, дамп бд храниться в db_dumps

Роуты:
classroom_show     GET      ANY      ANY    /api/classroom/show/all     
classroom_view     GET      ANY      ANY    /api/classroom/show/{id}    
classroom_create   POST     ANY      ANY    /api/classroom/create       
classroom_delete   DELETE   ANY      ANY    /api/classroom/delete/{id}  
classroom_update   PUT      ANY      ANY    /api/classroom/update/{id}
