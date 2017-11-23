
1. Встановити модуль Ocmod із папки ocmod.  

2. Створити додаток Facebook (https://developers.facebook.com/apps/) та Google (https://console.cloud.google.com/apis/). 

2.1 Facebook: у вкладці App Review зробити додаток публічним.

3. Прописати в налаштуваннях Адрес сайту, додаток 1,2.

4. Прописати ID додатка Facebook (catalog/view/javascript/oauth/config.json). 

5 Прописати ID додатка Google, секретний ключ і редирект на келбек (Повернення) сайта /catalog/controller/auth/config.php

5.1 Приклад: ['client_secret' => '<Секретний ключ>','client_id' => '<ID додатка>' , 'redirect_url' => '<ваш келбек>/glogin'];

5.2 Для роботи авторизації через Google потрібно зробити SEO URL auth/oauth/glogin -> glogin.  

6. Підключити javascript oauth.js на прикладі:

<script src="/catalog/view/javascript/oauth/oauth.js"></script>

7. Поставити кнопки на вхід на прикладі: 

<input type="image" src='/image/facebook.png' alt="Submit" width="48" height="48" onclick="dix_facebook()">
<input type="image" src='/image/google.png' alt="Submit" width="48" height="48" onclick="dix_googlePop('/glogin', 'ds', 700, 500)">

*Можливо створити свою кнопку використовуючи js функції для Google dix_googlePop('<келбек>', '<тайтл окна>', <висота поп арта>, <ширина поп арта>)
*Можливо створити свою кнопку використовуючи js функції для Facebook dix_facebook()

*Для зручності дивіться скриншоти в послідовності 1>2>3

*Модуль призначений для авторизації/реєстрації користувачів через соціальни мережі Google+ і Facebook.

ENG

1. Install the Ocmod module from the ocmod folder.

2. Create a Facebook app (https://developers.facebook.com/apps/) and Google app (https://console.cloud.google.com/apis/).

2.1 Facebook: In the App Review tab, make the application public.

3. Type the website address in the settings (see screenshots 1,2)

4. Type the Facebook application ID (catalog/view/javascript/oauth/config.json).

5. Type the Google application ID, secret key and redirect to the callback (Return) of the website /catalog/controller/auth/config.php

5.1 Example: ['client_secret' => '<secret key>','client_id' => '<app ID>' , 'redirect_url' => '<your callback>/glogin'].
5.2 For Google authorization to work, make the SEO URL auth/oauth/glogin -> glogin.

6. Install javascript oauth.js.

Example: <script src="/catalog/view/javascript/oauth/oauth.js"></script>

7. Set the login buttons.

Example: <input type="image" src='/image/facebook.png' alt="Submit" width="48" height="48" onclick="dix_facebook()">
<input type="image" src='/image/google.png' alt="Submit" width="48" height="48" onclick="dix_googlePop('/glogin', 'ds', 700, 500)">

Notes

*You can create your own button for Google using js functions dix_googlePop ('<callback>', '<window title>', <pop art height>, <pop art width>).

*You can create your own button for Facebook using  js functions dix_facebook().

*For your convenience, also see the screenshots in the sequence 1>2>3.

RU

1. Установите модуль Ocmod из папки ocmod. 

2. Создайте приложение Facebook (https://developers.facebook.com/apps/) и Google (https://console.cloud.google.com/apis/). 

2.1 Facebook: во вкладке App Review сделайте приложение публичным.

3. Пропишите в настройках адрес сайта (см. скриншот 1,2)

4. Пропишите ID приложения Facebook (catalog/view/javascript/oauth/config.json). 

5 Пропишите ID приложения Google, секретный ключ и редирект на келбек (Возвращение) сайта /catalog/controller/auth/config.php

5.1 Пример: ['client_secret' => '<Секретный ключ>','client_id' => '<ID приложения>', 'redirect_url' => '<ваш келбек>/glogin'];

5.2 Для работы авторизации через Google нужно сделать SEO URL auth/oauth/glogin -> glogin.  

6. Подключите javascript oauth.js.

Пример: <script src="/catalog/view/javascript/oauth/oauth.js"></script>

7. Установите кнопки на вход. 

Пример: <input type="image" src='/image/facebook.png' alt="Submit" width="48" height="48" onclick="dix_facebook()">
<input type="image" src='/image/google.png' alt="Submit" width="48" height="48" onclick="dix_googlePop('/glogin', 'ds', 700, 500)">

Примечания:

*Создать свою кнопку для Googlе можно, используя js функции dix_googlePop('<келбек>', '<тайтл окна>', <высота поп арта>, <ширина поп арта>)

*Создать свою кнопку для Facebook можно, используя js функции dix_facebook()

*Для вашего удобства также смотрите скриншоты в последовательности 1>2>3
