1. Встановити модуль Ocmod із папки ocmod.  

2. Створити додаток Facebook (https://developers.facebook.com/apps/) та Google (https://console.cloud.google.com/apis/). 

2.1 Facebook: у вкладці App Review зробити додаток публічним.

3. Прописати в налаштуваннях Адрес сайту, додаток 1,2.

4. Прописати Адмінці налаштування Користуваці->Авторизація через соціальни мережі.      

5. Підключити javascript oauth.js на прикладі:

<script src="/catalog/view/javascript/oauth/oauth.js"></script>

6. Поставити кнопки на вхід на прикладі: 

<input type="image" src='/image/facebook.png' alt="Submit" width="48" height="48" onclick="dix_facebook()">
<input type="image" src='/image/google.png' alt="Submit" width="48" height="48" onclick="dix_googlePop('/glogin', 'ds', 700, 500)">

*Можливо створити свою кнопку використовуючи js функції для Google dix_googlePop('<келбек>', '<тайтл окна>', <висота поп арта>, <ширина поп арта>)
*Можливо створити свою кнопку використовуючи js функції для Facebook dix_facebook()

*Для зручності дивіться скриншоти в послідовності 1>2>3

*Модуль призначений для авторизації/реєстрації користувачів через соціальни мережі Google+ і Facebook.
