## Настройка проекта

После скачивания выполните в директории проекта команду 
    ```sh start.sh```

## Работа с проектом

В проекте реализованы следующие методы:
> Внимание!
> Так как предполагается, что пользователь всегда авторизован под логином `admin`, то, для имитирования доступа к API по ключу, в каждом запросе должен передаваться заголовок `login: admin`
1. Генерирование стартового набора данных
```
GET   
http://localhost:8080/product/generate
```
Пример запроса:
```
curl --request GET 'http://localhost:8080/product/generate' --header 'login: admin'
```
Пример ответа:
- успешный
```
{
    "success": true,
    "message": "Стартовый набор данных сгенерирован"
}
```
- ошибочный
```
{
    "success": false,
    "message": "Доступ закрыт"
}
```
2. Создание заказа
```
POST
http://localhost:8080/order/create
```
Необходимо передать список идентификаторов товаров в поле `products`. Пример запроса:
```
curl --request POST 'http://localhost:8080/order/create' --header 'login: admin' --form 'products={"prod1":1,"prod2":2,"prod3":3}'
```
Пример ответа:
- успешный
```
{
    "success": true,
    "message": "Заказ успешно создан",
    "orderId": 2,
    "orderNumber": 92353,
    "orderSum": 6718
}
```
- ошибочный
```
{
    "success": false,
    "message": "Не указаны товары для заказа"
}
```
3. Оплата заказа
```
POST
http://localhost:8080/order/create
```
Необходимо передать в поле `order` следующие данные
| Поле | Тип | Описание |
|:----:|:----:|:----------:|
| **id** | int | Идентификатор заказа |
| **sum** | double | Сумма заказа |

Пример запроса:
```
curl --request POST 'http://localhost:8080/order/pay' --header 'login: admin' --form 'order={"id":1,"sum":6718}'
```
Пример ответа:
- успешный
```
{
    "success": true,
    "message": "Оплата принята"
}
```
- ошибочный
```
{
    "success": false,
    "message": "Заказ не найден"
}
```