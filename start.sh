#!/usr/bin/env bash

echo 'Запускаем сборку докера!'
docker-compose up -d || exit
echo  '\n'
echo "Докер успешно собрался! "
echo  '\n'
echo 'Теперь нам необходимо подождать 60 секунд пока установятся пакеты композера.'
sleep 10
echo 'Осталось еще 50 секунд...'
sleep 10
echo 'Осталось еще 40 секунд...'
sleep 10
echo 'Осталось еще 30 секунд...'
sleep 10
echo 'Осталось еще 20 секунд...'
sleep 5
echo 'Осталось еще 15 секунд...'
sleep 5
echo 'Осталось еще 10 секунд...'
sleep 5
echo 'Осталось еще 5 секунд...'
sleep 5
echo 'Сон завершился. Пакеты установлены! Теперь можем создать таблицы нашей БД.'
docker-compose exec php bash -c 'cd ../vi-project && vendor/bin/doctrine orm:schema-tool:update -f'
echo  '\n'
echo  "База успешно обновлена! Настройка проекта завершена."
