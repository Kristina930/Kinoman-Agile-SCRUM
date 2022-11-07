# **Проект "Kinoman" интернет-сервис о кино**

### Командная разработка по методологии Agile:Scrum
___
### Описание проекта: 
### Это интернет-сервис с
- [x] многофункциональным поиском
- [x] подробным описанием фильмов
- [x] подбором фильмов и сериалов по жанрам, актерам, режиссерам и годам
- [x] возможностью зарегистрироваться и создать личный кабинет

### Зарегистрированые пользователи могут:
- [x] добавлять фильмы в свои списки
- [x] выставлять фильмам оценки, эмодзи, хэштеги
- [x] делиться своими киновкусами с друзьями и всеми желающими
- [x] делать свой личный кабинет приватням или общедоступным
____
### Базовая документация к проекту:
#### :white_check_mark: HTML 5
#### :white_check_mark: CSS 2.1 (LESS)
#### :white_check_mark: GIT
#### :white_check_mark: Figma
#### :white_check_mark: PHP (Laravel)
#### :white_check_mark: MySQL
#### :white_check_mark: JavaScript
#### :white_check_mark: jQuery

## Установка необходимого ПО
#### Обновляем информацию о репозиториях
```git
apt update
```
## Установка Laravel
```laravel
curl -s https://laravel.build/kinoman | bash
```
### Перейти в каталог приложения kinoman
```git
cd kinoman 
```
### После запуска контейнеров запускаем http://localhost
___
### Подготавливаем директорию для проекта:
#### Создаем директорию для проекта
```git
mkdir project/kinoman
```
#### Переходим в директорию проекта и создаем в нем начальный файл
```git
cd kinoman
```
```html
index.html
```
### В проекте переходим в файл .env.example, меняем логин и пароль на свой
```laravel
DB_USERNAME=root
DB_PASSWORD=
```
___
### Создаем репозитории для проекта на github:
#### Создаем ssh-ключ для репозитория и дальнейшей разработки
```git
ssh-keygen
```
#### Извлекаем ключ для добавления его в репозиторий в качестве Deploy key
```git
cat /root/.ssh/id_rsa.pub
```
#### Данный ключ в настройках проекта на git нужно добавить, как Deploy key. 
#### Это нужно для того, чтобы не вводить пароль от git каждый раз при обращении к репозиторию.
#### После добавления ключа копируем информацию для клонирования репозитория по SSH, после чего запускаем клонирование.
#### Клонирование проекта
```git
git@github.com:Kristina930/Kinoman-Agile-SCRUM.git
```
#### Переходим в корневой каталог проекта
```git
cd kinoman/
```
___
### Требования к курсовому проекту
+ Верстка всех страниц со стилизацией согласно дизайн-макету
+ Сайт должен быть адаптивный и кроссбраузерный
+ Работа в команде по методологии SCRUM
___

### Адрес проекта: http://kinoman.fun/catalog где можно посмотреть его и протестировать.
