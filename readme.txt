
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
