# ModifyChat

## Задача
Реализовать простое приложение PHP с пользовательской 
аутентификацией, используя архитектуру MVC и маршрутизацию 
на основе запрашиваемого пути.

## Описание
### Предисловие
- Начальная конфигурация бд лежит в `sql-scripts/initDB.sql`
- В процессе написания этой лабы, были использованы MVC и 
маршрутизация с помощью `$_SERVER['REQUEST_URI']`
- Так же были использованы паттерны 
**Service locator** и **Composition root**.

### Аутентификация
Аутентификация сделана через куки с использованием 
кастомизированного sha1.

### Пользователь может
- Писать сообщения на главной странице.
- Просматривать свой профиль и менять логин с паролем на странице `/profile`. При 
этом аватарка пользователя остаётся такой же, какая 
ему была дана при регистрации.

### Неудачные запросы
При неудачных запросах будут отображаться кастомные страницы 
ошибок с соответствующими статус кодами.

### Продуктовое мышление
В этом плане есть спорные моменты, но в этой лабе 
решил сильно с этим не запариваться.