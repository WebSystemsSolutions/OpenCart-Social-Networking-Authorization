В версии 2.1 было добавлена возможность настройки авторизации через Instagram. Также был изменен алгоритм авторизации через Facebook - теперь работает через OAuth 2.

Установка модуля
1. Выгрузить файлы модуля в корень проекта
2. Установить модуль "WS SocialAuth" в Дополнения -> Модули
3. Пользуясь инструкцией на странице настроек модуля "Install", осуществить дополнительные настройки

Настройка API Facebook
Создать приложение Facebook https://developers.facebook.com/apps/
Сделать приложение публичным и прописать callback href (взять в настройках модуля)
Прописать App ID и Secret App в настройки модуля

Настройка API Google+
Создать приложение Google https://console.cloud.google.com/apis/
Прописать callback href (взять в настройках модуля)
Прописать App ID и secret key в настройки модуля

Настройка API Instagram
Зарегистрировать разработчика - https://www.instagram.com/developer/register/
Создать Client - https://www.instagram.com/developer/clients/register/
Прописать callback href (взять в настройках модуля)
Прописать App ID и secret key в настройки модуля