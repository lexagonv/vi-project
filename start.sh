#!/usr/bin/env bash

echo 'Запускаем сборку докера!'
docker-compose up -d || exit
echo  '\n'
echo "Докер успешно собрался! "
echo  '\n'
#echo 'Теперь нам необходимо собрать композер.'
#docker-compose exec composer bash -c 'composer install'
echo 'Теперь нам необходимо подождать 115 секунд пока установятся пакеты композера.'
sleep 15
echo 'Осталось еще 100 секунд...'
sleep 20
echo 'Осталось еще 80 секунд...'
sleep 20
echo 'Осталось еще 60 секунд...'
sleep 20
echo 'Осталось еще 40 секунд...'
sleep 20
echo 'Осталось еще 20 секунд...'
sleep 5
echo 'Осталось еще 15 секунд...'
sleep 5
echo 'Осталось еще 10 секунд...'
sleep 5
echo 'Осталось еще 5 секунд...'
sleep 5
echo 'Сон завершился. Пакеты установлены! Теперь можем создать таблицы нашей БД.'
#echo 'Пакеты установлены! Теперь можем создать таблицы нашей БД.'
docker-compose exec php bash -c 'cd ../vi-project && vendor/bin/doctrine orm:schema-tool:update -f'
echo  '\n'
echo  "База успешно обновлена! Настройка проекта завершена."
