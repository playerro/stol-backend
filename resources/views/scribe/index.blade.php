<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Stol API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://localhost";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.2.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.2.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-POSTapi-webhook">
                                <a href="#endpoints-POSTapi-webhook">Handle the telegram webhook request.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-obccenie" class="tocify-header">
                <li class="tocify-item level-1" data-unique="obccenie">
                    <a href="#obccenie">Обцчение</a>
                </li>
                                    <ul id="tocify-subheader-obccenie" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="obccenie-GETapi-tutorial-status">
                                <a href="#obccenie-GETapi-tutorial-status">Статус обучения</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="obccenie-POSTapi-tutorial-complete">
                                <a href="#obccenie-POSTapi-tutorial-complete">Завершить обучение</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="obccenie-POSTapi-tutorial-skip">
                                <a href="#obccenie-POSTapi-tutorial-skip">Пропустить обучение</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-otzyvy" class="tocify-header">
                <li class="tocify-item level-1" data-unique="otzyvy">
                    <a href="#otzyvy">Отзывы</a>
                </li>
                                    <ul id="tocify-subheader-otzyvy" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="otzyvy-POSTapi-reviews">
                                <a href="#otzyvy-POSTapi-reviews">Оставить отзыв на чек</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-offery" class="tocify-header">
                <li class="tocify-item level-1" data-unique="offery">
                    <a href="#offery">Офферы</a>
                </li>
                                    <ul id="tocify-subheader-offery" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="offery-GETapi-offers-index">
                                <a href="#offery-GETapi-offers-index">Список офферов</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="offery-GETapi-offers--offer_id-">
                                <a href="#offery-GETapi-offers--offer_id-">Детали оффера</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="offery-POSTapi-offers--offer_id--purchase">
                                <a href="#offery-POSTapi-offers--offer_id--purchase">Покупка оффера</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-polzovateli" class="tocify-header">
                <li class="tocify-item level-1" data-unique="polzovateli">
                    <a href="#polzovateli">Пользователи</a>
                </li>
                                    <ul id="tocify-subheader-polzovateli" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="polzovateli-GETapi-user">
                                <a href="#polzovateli-GETapi-user">Информация о пользователе</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="polzovateli-POSTapi-user">
                                <a href="#polzovateli-POSTapi-user">Обновить профиль</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-reiting" class="tocify-header">
                <li class="tocify-item level-1" data-unique="reiting">
                    <a href="#reiting">Рейтинг</a>
                </li>
                                    <ul id="tocify-subheader-reiting" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="reiting-GETapi-leaderboard">
                                <a href="#reiting-GETapi-leaderboard">Список топ‑100 и позиция текущего пользователя</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-restorany" class="tocify-header">
                <li class="tocify-item level-1" data-unique="restorany">
                    <a href="#restorany">Рестораны</a>
                </li>
                                    <ul id="tocify-subheader-restorany" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="restorany-GETapi-restaurants-search">
                                <a href="#restorany-GETapi-restaurants-search">Поиск ресторана по имени, ИНН или адресу</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-uvedomleniia" class="tocify-header">
                <li class="tocify-item level-1" data-unique="uvedomleniia">
                    <a href="#uvedomleniia">Уведомления</a>
                </li>
                                    <ul id="tocify-subheader-uvedomleniia" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="uvedomleniia-GETapi-notifications-index">
                                <a href="#uvedomleniia-GETapi-notifications-index">Список уведомлений пользователя</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="uvedomleniia-GETapi-notifications-unread-count">
                                <a href="#uvedomleniia-GETapi-notifications-unread-count">Количество непрочитанных уведомлений</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="uvedomleniia-POSTapi-notifications--notification_id--read">
                                <a href="#uvedomleniia-POSTapi-notifications--notification_id--read">Пометить уведомление как прочитанное</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-ceki" class="tocify-header">
                <li class="tocify-item level-1" data-unique="ceki">
                    <a href="#ceki">Чеки</a>
                </li>
                                    <ul id="tocify-subheader-ceki" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="ceki-POSTapi-receipts">
                                <a href="#ceki-POSTapi-receipts">Загрузка чека</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="ceki-GETapi-receipts-history">
                                <a href="#ceki-GETapi-receipts-history">История сканированных чеков</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="ceki-GETapi-receipts-history-restaurant">
                                <a href="#ceki-GETapi-receipts-history-restaurant">История чеков по конкретному ресторану</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: July 27, 2025</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://localhost</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-POSTapi-webhook">Handle the telegram webhook request.</h2>

<p>
</p>



<span id="example-requests-POSTapi-webhook">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/webhook" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/webhook"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-webhook">
</span>
<span id="execution-results-POSTapi-webhook" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-webhook"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-webhook"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-webhook" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-webhook">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-webhook" data-method="POST"
      data-path="api/webhook"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-webhook', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-webhook"
                    onclick="tryItOut('POSTapi-webhook');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-webhook"
                    onclick="cancelTryOut('POSTapi-webhook');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-webhook"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/webhook</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-webhook"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-webhook"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="obccenie">Обцчение</h1>

    <p>API обучения</p>

                                <h2 id="obccenie-GETapi-tutorial-status">Статус обучения</h2>

<p>
</p>



<span id="example-requests-GETapi-tutorial-status">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/tutorial/status?code=architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/tutorial/status"
);

const params = {
    "code": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-tutorial-status">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;tutorial_completed&quot;: false,
    &quot;bonus_available&quot;: true
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Пользователь не найден&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-tutorial-status" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-tutorial-status"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-tutorial-status"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-tutorial-status" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-tutorial-status">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-tutorial-status" data-method="GET"
      data-path="api/tutorial/status"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-tutorial-status', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-tutorial-status"
                    onclick="tryItOut('GETapi-tutorial-status');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-tutorial-status"
                    onclick="cancelTryOut('GETapi-tutorial-status');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-tutorial-status"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/tutorial/status</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-tutorial-status"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-tutorial-status"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="GETapi-tutorial-status"
               value="architecto"
               data-component="query">
    <br>
<p>UUID пользователя. Example: <code>architecto</code></p>
            </div>
                </form>

                    <h2 id="obccenie-POSTapi-tutorial-complete">Завершить обучение</h2>

<p>
</p>



<span id="example-requests-POSTapi-tutorial-complete">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/tutorial/complete?code=architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/tutorial/complete"
);

const params = {
    "code": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-tutorial-complete">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Бонус начислен&quot;,
    &quot;points&quot;: 10
}</code>
 </pre>
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Бонус уже получен&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Пользователь не найден&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-tutorial-complete" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-tutorial-complete"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-tutorial-complete"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-tutorial-complete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-tutorial-complete">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-tutorial-complete" data-method="POST"
      data-path="api/tutorial/complete"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-tutorial-complete', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-tutorial-complete"
                    onclick="tryItOut('POSTapi-tutorial-complete');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-tutorial-complete"
                    onclick="cancelTryOut('POSTapi-tutorial-complete');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-tutorial-complete"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/tutorial/complete</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-tutorial-complete"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-tutorial-complete"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="POSTapi-tutorial-complete"
               value="architecto"
               data-component="query">
    <br>
<p>UUID пользователя. Example: <code>architecto</code></p>
            </div>
                </form>

                    <h2 id="obccenie-POSTapi-tutorial-skip">Пропустить обучение</h2>

<p>
</p>



<span id="example-requests-POSTapi-tutorial-skip">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/tutorial/skip?code=architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/tutorial/skip"
);

const params = {
    "code": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-tutorial-skip">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Обучение пропущено&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-tutorial-skip" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-tutorial-skip"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-tutorial-skip"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-tutorial-skip" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-tutorial-skip">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-tutorial-skip" data-method="POST"
      data-path="api/tutorial/skip"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-tutorial-skip', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-tutorial-skip"
                    onclick="tryItOut('POSTapi-tutorial-skip');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-tutorial-skip"
                    onclick="cancelTryOut('POSTapi-tutorial-skip');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-tutorial-skip"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/tutorial/skip</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-tutorial-skip"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-tutorial-skip"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="POSTapi-tutorial-skip"
               value="architecto"
               data-component="query">
    <br>
<p>UUID пользователя. Example: <code>architecto</code></p>
            </div>
                </form>

                <h1 id="otzyvy">Отзывы</h1>

    <p>Оставление отзывов на чеки</p>

                                <h2 id="otzyvy-POSTapi-reviews">Оставить отзыв на чек</h2>

<p>
</p>



<span id="example-requests-POSTapi-reviews">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/reviews?code=architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"receipt_id\": \"architecto\",
    \"rating\": 16,
    \"text\": \"architecto\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/reviews"
);

const params = {
    "code": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "receipt_id": "architecto",
    "rating": 16,
    "text": "architecto"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-reviews">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;id&quot;: &quot;d4f3a2b1-5c6d-7e8f-1234-abcdef567890&quot;,
        &quot;receipt_id&quot;: &quot;019668b1-9b61-72a3-8904-61dcda70cd81&quot;,
        &quot;rating&quot;: 5,
        &quot;text&quot;: &quot;Отличный ресторан, рекомендую!&quot;,
        &quot;created_at&quot;: &quot;2025-04-27T12:34:56.000000Z&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Произошла ошибка&quot;,
    &quot;error&quot;: &quot;Чек не принадлежит вам.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Произошла ошибка сервера&quot;,
    &quot;error&quot;: &quot;Произошла ошибка сервера&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-reviews" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-reviews"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-reviews"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-reviews" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-reviews">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-reviews" data-method="POST"
      data-path="api/reviews"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-reviews', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-reviews"
                    onclick="tryItOut('POSTapi-reviews');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-reviews"
                    onclick="cancelTryOut('POSTapi-reviews');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-reviews"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/reviews</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-reviews"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-reviews"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="POSTapi-reviews"
               value="architecto"
               data-component="query">
    <br>
<p>UUID пользователя. Пример: 123e4567-e89b-12d3-a456-426614174000 Example: <code>architecto</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>receipt_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="receipt_id"                data-endpoint="POSTapi-reviews"
               value="architecto"
               data-component="body">
    <br>
<p>UUID чека. Пример: 019668b1-9b61-72a3-8904-61dcda70cd81 Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>rating</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="rating"                data-endpoint="POSTapi-reviews"
               value="16"
               data-component="body">
    <br>
<p>Оценка от 1 до 5. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>text</code></b>&nbsp;&nbsp;
<small>string|null</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="text"                data-endpoint="POSTapi-reviews"
               value="architecto"
               data-component="body">
    <br>
<p>Текст отзыва (макс. 2000 символов). Example: <code>architecto</code></p>
        </div>
        </form>

                <h1 id="offery">Офферы</h1>

    <p>API для получения списка, деталей и покупки офферов</p>

                                <h2 id="offery-GETapi-offers-index">Список офферов</h2>

<p>
</p>



<span id="example-requests-GETapi-offers-index">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/offers/index?code=architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/offers/index"
);

const params = {
    "code": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-offers-index">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
  &quot;data&quot;: [
    {
      &quot;id&quot;: 1,
      &quot;name&quot;: &quot;Premium-подписка&quot;,
      &quot;description&quot;: &quot;Месяц доступа к премиум-функциям&quot;,
      &quot;price&quot;: 500,
      &quot;image_url&quot;: &quot;https://&hellip;&quot;,
      &quot;category&quot;: &quot;Подписки&quot;,
      &quot;store&quot;: &quot;Telegram&quot;,
      &quot;disabled&quot;: false
    },
  ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Пользователь не найден&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-offers-index" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-offers-index"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-offers-index"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-offers-index" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-offers-index">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-offers-index" data-method="GET"
      data-path="api/offers/index"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-offers-index', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-offers-index"
                    onclick="tryItOut('GETapi-offers-index');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-offers-index"
                    onclick="cancelTryOut('GETapi-offers-index');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-offers-index"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/offers/index</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-offers-index"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-offers-index"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="GETapi-offers-index"
               value="architecto"
               data-component="query">
    <br>
<p>UUID пользователя. Пример: 123e4567-e89b-12d3-a456-426614174000 Example: <code>architecto</code></p>
            </div>
                </form>

                    <h2 id="offery-GETapi-offers--offer_id-">Детали оффера</h2>

<p>
</p>



<span id="example-requests-GETapi-offers--offer_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/offers/1?code=architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/offers/1"
);

const params = {
    "code": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-offers--offer_id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;name&quot;: &quot;Premium-подписка&quot;,
        &quot;description&quot;: &quot;&hellip;&quot;,
        &quot;price&quot;: 500,
        &quot;image_url&quot;: &quot;https://&hellip;&quot;,
        &quot;category&quot;: &quot;Подписки&quot;,
        &quot;store&quot;: &quot;Telegram&quot;,
        &quot;disabled&quot;: false
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Пользователь не найден&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-offers--offer_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-offers--offer_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-offers--offer_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-offers--offer_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-offers--offer_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-offers--offer_id-" data-method="GET"
      data-path="api/offers/{offer_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-offers--offer_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-offers--offer_id-"
                    onclick="tryItOut('GETapi-offers--offer_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-offers--offer_id-"
                    onclick="cancelTryOut('GETapi-offers--offer_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-offers--offer_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/offers/{offer_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-offers--offer_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-offers--offer_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>offer_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="offer_id"                data-endpoint="GETapi-offers--offer_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the offer. Example: <code>1</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="GETapi-offers--offer_id-"
               value="architecto"
               data-component="query">
    <br>
<p>UUID пользователя. Example: <code>architecto</code></p>
            </div>
                </form>

                    <h2 id="offery-POSTapi-offers--offer_id--purchase">Покупка оффера</h2>

<p>
</p>



<span id="example-requests-POSTapi-offers--offer_id--purchase">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/offers/1/purchase?code=architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/offers/1/purchase"
);

const params = {
    "code": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-offers--offer_id--purchase">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Успешно куплено&quot;,
    &quot;points&quot;: 1200,
    &quot;purchase_id&quot;: 5
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Пользователь не найден&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Недостаточно баллов&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-offers--offer_id--purchase" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-offers--offer_id--purchase"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-offers--offer_id--purchase"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-offers--offer_id--purchase" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-offers--offer_id--purchase">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-offers--offer_id--purchase" data-method="POST"
      data-path="api/offers/{offer_id}/purchase"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-offers--offer_id--purchase', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-offers--offer_id--purchase"
                    onclick="tryItOut('POSTapi-offers--offer_id--purchase');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-offers--offer_id--purchase"
                    onclick="cancelTryOut('POSTapi-offers--offer_id--purchase');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-offers--offer_id--purchase"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/offers/{offer_id}/purchase</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-offers--offer_id--purchase"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-offers--offer_id--purchase"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>offer_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="offer_id"                data-endpoint="POSTapi-offers--offer_id--purchase"
               value="1"
               data-component="url">
    <br>
<p>The ID of the offer. Example: <code>1</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="POSTapi-offers--offer_id--purchase"
               value="architecto"
               data-component="query">
    <br>
<p>UUID пользователя. Example: <code>architecto</code></p>
            </div>
                </form>

                <h1 id="polzovateli">Пользователи</h1>

    <p>API пользователей</p>

                                <h2 id="polzovateli-GETapi-user">Информация о пользователе</h2>

<p>
</p>



<span id="example-requests-GETapi-user">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/user?code=architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/user"
);

const params = {
    "code": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-user">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
   &quot;data&quot;: {
     &quot;avatar&quot;: &quot;https://cdn.example.com/avatars/abcd1234.jpg&quot;,
     &quot;username&quot;: &quot;ivan_petrov&quot;,
     &quot;points&quot;: 245,
     &quot;points_remainder&quot;: 56,
     &quot;daily_streak&quot;: 5,
     &quot;visits&quot;: 42,
     &quot;average_check&quot;: &quot;123.45&quot;,
     &quot;telegram_id&quot;: 987654321,
     &quot;first_name&quot;: &quot;Иван&quot;,
     &quot;last_name&quot;: &quot;Петров&quot;,
     &quot;theme&quot;: &quot;dark&quot;,
     &quot;created_at&quot;: &quot;2024-12-01T14:23:45.000000Z&quot;,
     &quot;rank&quot;: {
       &quot;current&quot;: &quot;Silver&quot;,
       &quot;current_id&quot;: &quot;1&quot;,
       &quot;next&quot;: &quot;Gold&quot;,
       &quot;next_id&quot;: &quot;2&quot;,
       &quot;conditions_current&quot;: { &quot;scans&quot;: 10, &quot;sum_spent&quot;: 5000, &quot;streak_days&quot;: 7 },
       &quot;conditions_next&quot;:    { &quot;scans&quot;: 15, &quot;sum_spent&quot;: 15000, &quot;streak_days&quot;: 15 },
       &quot;progress_current&quot;:   { &quot;scans&quot;: 3,  &quot;sum_spent&quot;: 1200.50, &quot;streak_days&quot;: 2 }
     },
     &quot;favorite&quot;: {
       &quot;label&quot;: &quot;Любимое&quot;,
       &quot;id&quot;: &quot;b2d5f7a4-3e56-4c1e-9c3b-123456789abc&quot;,
       &quot;name&quot;: &quot;La Pergola&quot;,
       &quot;image_url&quot;: &quot;https://cdn.example.com/announcements/abcd1234.jpg&quot;,
       &quot;rating&quot;: 4.75,
       &quot;checks_count&quot;: 5,
       &quot;sum_spent&quot;: 2345.67
     },
     &quot;recent&quot;: {
       &quot;label&quot;: &quot;Недавнее&quot;,
       &quot;id&quot;: &quot;b2d5f7a4-3e56-4c1e-9c3b-123456789abc&quot;,
       &quot;name&quot;: &quot;La Pergola&quot;,
       &quot;image_url&quot;: &quot;https://cdn.example.com/announcements/abcd1234.jpg&quot;,
       &quot;rating&quot;: 15,
       &quot;points&quot;: 15
     },
     &quot;referral_link&quot;: &quot;https://t.me/YourBot?start=refToken123&quot;
   }</code>
 </pre>
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Произошла ошибка&quot;,
    &quot;error&quot;: &quot;Подробное сообщение об ошибке&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Произошла ошибка&quot;,
    &quot;error&quot;: &quot;Ошибка&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-user" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-user"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-user"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-user" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-user">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-user" data-method="GET"
      data-path="api/user"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-user', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-user"
                    onclick="tryItOut('GETapi-user');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-user"
                    onclick="cancelTryOut('GETapi-user');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-user"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/user</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="GETapi-user"
               value="architecto"
               data-component="query">
    <br>
<p>UUID пользователя. Пример: 123e4567-e89b-12d3-a456-426614174000 Example: <code>architecto</code></p>
            </div>
                </form>

                    <h2 id="polzovateli-POSTapi-user">Обновить профиль</h2>

<p>
</p>



<span id="example-requests-POSTapi-user">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/user?code=architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"username\": \"b\",
    \"theme\": \"gray-black\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/user"
);

const params = {
    "code": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "username": "b",
    "theme": "gray-black"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-user">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;avatar&quot;: &quot;https://&hellip;&quot;,
        &quot;username&quot;: &quot;Paul&quot;,
        &quot;points&quot;: 245,
        &quot;daily_streak&quot;: 5,
        &quot;telegram_id&quot;: 987654321,
        &quot;first_name&quot;: &quot;Иван&quot;,
        &quot;last_name&quot;: &quot;Петров&quot;,
        &quot;theme&quot;: &quot;gray-brown&quot;,
        &quot;visits&quot;: 42,
        &quot;average_check&quot;: &quot;123.45&quot;,
        &quot;created_at&quot;: &quot;2024-12-01T14:23:45.000000Z&quot;,
        &quot;rank&quot;: {
            &quot;current&quot;: &quot;Bronze&quot;,
            &quot;next&quot;: null,
            &quot;progress&quot;: 0
        }
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Произошла ошибка&quot;,
    &quot;error&quot;: &quot;Ошибка&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;The given data was invalid.&quot;,
    &quot;errors&quot;: {
        &quot;theme&quot;: [
            &quot;Тема должна быть одной из: white-pink, gray-brown, gray-black&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-user" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-user"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-user"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-user" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-user">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-user" data-method="POST"
      data-path="api/user"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-user', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-user"
                    onclick="tryItOut('POSTapi-user');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-user"
                    onclick="cancelTryOut('POSTapi-user');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-user"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/user</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="POSTapi-user"
               value="architecto"
               data-component="query">
    <br>
<p>UUID пользователя. Пример: 123e4567-e89b-12d3-a456-426614174000 Example: <code>architecto</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>username</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="username"                data-endpoint="POSTapi-user"
               value="b"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>theme</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="theme"                data-endpoint="POSTapi-user"
               value="gray-black"
               data-component="body">
    <br>
<p>Example: <code>gray-black</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>white-pink</code></li> <li><code>gray-brown</code></li> <li><code>gray-black</code></li></ul>
        </div>
        </form>

                <h1 id="reiting">Рейтинг</h1>

    <p>API для страницы рейтинга</p>

                                <h2 id="reiting-GETapi-leaderboard">Список топ‑100 и позиция текущего пользователя</h2>

<p>
</p>



<span id="example-requests-GETapi-leaderboard">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/leaderboard?code=architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/leaderboard"
);

const params = {
    "code": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-leaderboard">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
  &quot;data&quot;: {
    &quot;leaders&quot;: [
      {
        &quot;position&quot;: 1,
        &quot;avatar&quot;: &quot;https://.../1.jpg&quot;,
        &quot;username&quot;: &quot;leader_one&quot;,
        &quot;points&quot;: 1500
      },
     {
        &quot;position&quot;: 2,
        &quot;avatar&quot;: &quot;https://.../1.jpg&quot;,
        &quot;username&quot;: &quot;leader_two&quot;,
        &quot;points&quot;: 1499
      },

    ],
    &quot;user&quot;: {
      &quot;position&quot;: 45,
      &quot;avatar&quot;: &quot;https://.../45.jpg&quot;,
      &quot;username&quot;: &quot;current_user&quot;,
      &quot;points&quot;: 800
    }
  }
}</code>
 </pre>
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Произошла ошибка&quot;,
    &quot;error&quot;: &quot;Пользователь не найден&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-leaderboard" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-leaderboard"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-leaderboard"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-leaderboard" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-leaderboard">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-leaderboard" data-method="GET"
      data-path="api/leaderboard"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-leaderboard', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-leaderboard"
                    onclick="tryItOut('GETapi-leaderboard');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-leaderboard"
                    onclick="cancelTryOut('GETapi-leaderboard');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-leaderboard"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/leaderboard</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-leaderboard"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-leaderboard"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="GETapi-leaderboard"
               value="architecto"
               data-component="query">
    <br>
<p>UUID пользователя. Пример: 123e4567-e89b-12d3-a456-426614174000 Example: <code>architecto</code></p>
            </div>
                </form>

                <h1 id="restorany">Рестораны</h1>

    <p>Всё, что связано с ресторанами</p>

                                <h2 id="restorany-GETapi-restaurants-search">Поиск ресторана по имени, ИНН или адресу</h2>

<p>
</p>



<span id="example-requests-GETapi-restaurants-search">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/restaurants/search?code=architecto&amp;q=sush" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/restaurants/search"
);

const params = {
    "code": "architecto",
    "q": "sush",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-restaurants-search">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;id&quot;: &quot;uuid&quot;,
            &quot;inn&quot;: &quot;1234567890&quot;,
            &quot;name&quot;: &quot;Суши-Сет&quot;,
            &quot;rating&quot;: &quot;4.50&quot;,
            &quot;description&quot;: &quot;...&quot;,
            &quot;city&quot;: &quot;Москва&quot;,
            &quot;country&quot;: &quot;Россия&quot;,
            &quot;address&quot;: &quot;ул. Пушкина, д.1&quot;,
            &quot;logo_url&quot;: &quot;https://...&quot;
        }
    ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (200, No results):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: []
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, Validation error):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;The given data was invalid.&quot;,
    &quot;errors&quot;: {
        &quot;q&quot;: [
            &quot;The q must be at least 3 characters.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-restaurants-search" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-restaurants-search"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-restaurants-search"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-restaurants-search" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-restaurants-search">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-restaurants-search" data-method="GET"
      data-path="api/restaurants/search"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-restaurants-search', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-restaurants-search"
                    onclick="tryItOut('GETapi-restaurants-search');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-restaurants-search"
                    onclick="cancelTryOut('GETapi-restaurants-search');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-restaurants-search"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/restaurants/search</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-restaurants-search"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-restaurants-search"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="GETapi-restaurants-search"
               value="architecto"
               data-component="query">
    <br>
<p>UUID пользователя. Пример: 123e4567-e89b-12d3-a456-426614174000 Example: <code>architecto</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>q</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="q"                data-endpoint="GETapi-restaurants-search"
               value="sush"
               data-component="query">
    <br>
<p>Search query. Минимум 3 символа. Example: <code>sush</code></p>
            </div>
                </form>

                <h1 id="uvedomleniia">Уведомления</h1>

    <p>API для работы со списком уведомлений, подсчётом непрочитанных и пометкой прочтения.</p>

                                <h2 id="uvedomleniia-GETapi-notifications-index">Список уведомлений пользователя</h2>

<p>
</p>



<span id="example-requests-GETapi-notifications-index">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/notifications/index?code=architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/notifications/index"
);

const params = {
    "code": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-notifications-index">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
  &quot;data&quot;: [
    {
      &quot;id&quot;: 10,
      &quot;type&quot;: &quot;purchase&quot;,
      &quot;title&quot;: &quot;Недавняя покупка&quot;,
      &quot;subtitle&quot;: &quot;Куплен Telegram Premium&quot;,
      &quot;body&quot;: &quot;Telegram Premium на 3 месяца будет начислен завтра.&quot;,
      &quot;is_read&quot;: false,
      &quot;created_at&quot;: &quot;2025-07-26T12:34:56Z&quot;
    },

  ],
  &quot;meta&quot;: {
    &quot;current_page&quot;: 1,
    &quot;last_page&quot;: 3,
    &quot;per_page&quot;: 20,
    &quot;total&quot;: 45
  }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Пользователь не найден&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-notifications-index" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-notifications-index"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-notifications-index"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-notifications-index" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-notifications-index">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-notifications-index" data-method="GET"
      data-path="api/notifications/index"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-notifications-index', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-notifications-index"
                    onclick="tryItOut('GETapi-notifications-index');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-notifications-index"
                    onclick="cancelTryOut('GETapi-notifications-index');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-notifications-index"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/notifications/index</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-notifications-index"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-notifications-index"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="GETapi-notifications-index"
               value="architecto"
               data-component="query">
    <br>
<p>UUID пользователя. Пример: 123e4567-e89b-12d3-a456-426614174000 Example: <code>architecto</code></p>
            </div>
                </form>

                    <h2 id="uvedomleniia-GETapi-notifications-unread-count">Количество непрочитанных уведомлений</h2>

<p>
</p>



<span id="example-requests-GETapi-notifications-unread-count">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/notifications/unread-count?code=architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/notifications/unread-count"
);

const params = {
    "code": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-notifications-unread-count">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;unread_count&quot;: 5
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Пользователь не найден&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-notifications-unread-count" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-notifications-unread-count"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-notifications-unread-count"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-notifications-unread-count" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-notifications-unread-count">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-notifications-unread-count" data-method="GET"
      data-path="api/notifications/unread-count"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-notifications-unread-count', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-notifications-unread-count"
                    onclick="tryItOut('GETapi-notifications-unread-count');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-notifications-unread-count"
                    onclick="cancelTryOut('GETapi-notifications-unread-count');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-notifications-unread-count"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/notifications/unread-count</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-notifications-unread-count"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-notifications-unread-count"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="GETapi-notifications-unread-count"
               value="architecto"
               data-component="query">
    <br>
<p>UUID пользователя. Example: <code>architecto</code></p>
            </div>
                </form>

                    <h2 id="uvedomleniia-POSTapi-notifications--notification_id--read">Пометить уведомление как прочитанное</h2>

<p>
</p>



<span id="example-requests-POSTapi-notifications--notification_id--read">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/notifications/1/read?code=architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/notifications/1/read"
);

const params = {
    "code": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-notifications--notification_id--read">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;OK&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (403):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Forbidden&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Пользователь не найден&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-notifications--notification_id--read" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-notifications--notification_id--read"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-notifications--notification_id--read"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-notifications--notification_id--read" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-notifications--notification_id--read">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-notifications--notification_id--read" data-method="POST"
      data-path="api/notifications/{notification_id}/read"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-notifications--notification_id--read', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-notifications--notification_id--read"
                    onclick="tryItOut('POSTapi-notifications--notification_id--read');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-notifications--notification_id--read"
                    onclick="cancelTryOut('POSTapi-notifications--notification_id--read');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-notifications--notification_id--read"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/notifications/{notification_id}/read</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-notifications--notification_id--read"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-notifications--notification_id--read"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>notification_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="notification_id"                data-endpoint="POSTapi-notifications--notification_id--read"
               value="1"
               data-component="url">
    <br>
<p>The ID of the notification. Example: <code>1</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="POSTapi-notifications--notification_id--read"
               value="architecto"
               data-component="query">
    <br>
<p>UUID пользователя. Example: <code>architecto</code></p>
            </div>
                </form>

                <h1 id="ceki">Чеки</h1>

    <p>Всё, что связано с чеками ресторанных посещений</p>

                                <h2 id="ceki-POSTapi-receipts">Загрузка чека</h2>

<p>
</p>



<span id="example-requests-POSTapi-receipts">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/receipts?code=architecto" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "receipt=@/tmp/phppv3o2r8a7ftf9rzM8rB" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/receipts"
);

const params = {
    "code": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('receipt', document.querySelector('input[name="receipt"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-receipts">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Чек отправлен на модерацию&quot;,
    &quot;points&quot;: 10,
    &quot;id&quot;: 1
}</code>
 </pre>
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Произошла ошибка&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
&quot;message&quot;: &quot;Пользователь не найден&quot;
}
/</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Описание доменной ошибки&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-receipts" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-receipts"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-receipts"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-receipts" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-receipts">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-receipts" data-method="POST"
      data-path="api/receipts"
      data-authed="0"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-receipts', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-receipts"
                    onclick="tryItOut('POSTapi-receipts');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-receipts"
                    onclick="cancelTryOut('POSTapi-receipts');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-receipts"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/receipts</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-receipts"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-receipts"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="POSTapi-receipts"
               value="architecto"
               data-component="query">
    <br>
<p>UUID пользователя. Пример: 123e4567-e89b-12d3-a456-426614174000 Example: <code>architecto</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>receipt</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="receipt"                data-endpoint="POSTapi-receipts"
               value=""
               data-component="body">
    <br>
<p>Must be a file. Example: <code>/tmp/phppv3o2r8a7ftf9rzM8rB</code></p>
        </div>
        </form>

                    <h2 id="ceki-GETapi-receipts-history">История сканированных чеков</h2>

<p>
</p>



<span id="example-requests-GETapi-receipts-history">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/receipts/history?code=architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/receipts/history"
);

const params = {
    "code": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-receipts-history">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
  &quot;data&quot;: [
    {
      &quot;id&quot;: &quot;019668b1-9b61-72a3-8904-61dcda70cd81&quot;,
      &quot;total_sum&quot;: 1500.20,
      &quot;points&quot;: 15,
      &quot;status&quot;: &quot;approved&quot;,
      &quot;created_at&quot;: &quot;2025-04-25T14:12:00Z&quot;,
      &quot;restaurant&quot;: {
        &quot;id&quot;: &quot;b2d5f7a4-3e56-4c1e-9c3b-123456789abc&quot;,
        &quot;inn&quot;: &quot;7728168971&quot;,
        &quot;name&quot;: &quot;La Pergola&quot;,
        &quot;rating&quot;: &quot;4.75&quot;,
        &quot;description&quot;: &quot;Итальянский ресторан на крыше&quot;,
        &quot;city&quot;: &quot;Москва&quot;,
        &quot;country&quot;: &quot;Россия&quot;,
        &quot;address&quot;: &quot;ул. Примерная, 10&quot;,
        &quot;image_url&quot;: &quot;https://cdn.example.com/announcements/abcd1234.jpg&quot;
      }
    },

  ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Произошла ошибка&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-receipts-history" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-receipts-history"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-receipts-history"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-receipts-history" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-receipts-history">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-receipts-history" data-method="GET"
      data-path="api/receipts/history"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-receipts-history', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-receipts-history"
                    onclick="tryItOut('GETapi-receipts-history');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-receipts-history"
                    onclick="cancelTryOut('GETapi-receipts-history');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-receipts-history"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/receipts/history</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-receipts-history"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-receipts-history"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="GETapi-receipts-history"
               value="architecto"
               data-component="query">
    <br>
<p>UUID пользователя. Пример: 123e4567-e89b-12d3-a456-426614174000 Example: <code>architecto</code></p>
            </div>
                </form>

                    <h2 id="ceki-GETapi-receipts-history-restaurant">История чеков по конкретному ресторану</h2>

<p>
</p>



<span id="example-requests-GETapi-receipts-history-restaurant">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/receipts/history/restaurant?code=architecto&amp;restaurant_id=architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/receipts/history/restaurant"
);

const params = {
    "code": "architecto",
    "restaurant_id": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-receipts-history-restaurant">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;id&quot;: &quot;019668b1-9b61-72a3-8904-61dcda70cd81&quot;,
            &quot;total_sum&quot;: 156,
            &quot;points&quot;: 1,
            &quot;status&quot;: &quot;approved&quot;,
            &quot;created_at&quot;: &quot;2025-04-24T18:28:00Z&quot;,
            &quot;restaurant&quot;: {
                &quot;id&quot;: &quot;b2d5f7a4-3e56-4c1e-9c3b-123456789abc&quot;,
                &quot;inn&quot;: &quot;7728168971&quot;,
                &quot;name&quot;: &quot;Mutabor&quot;,
                &quot;rating&quot;: 4.75,
                &quot;description&quot;: &quot;Современная кухня с авторским подходом&quot;,
                &quot;city&quot;: &quot;Москва&quot;,
                &quot;country&quot;: &quot;Россия&quot;,
                &quot;address&quot;: &quot;ул. Пречистенка, 27&quot;,
                &quot;image_url&quot;: &quot;https://cdn.example.com/announcements/mutabor.jpg&quot;
            }
        },
        {
            &quot;id&quot;: &quot;f3a1d2c4-6e78-90ab-cdef-1234567890ab&quot;,
            &quot;total_sum&quot;: 348,
            &quot;points&quot;: 3,
            &quot;status&quot;: &quot;approved&quot;,
            &quot;created_at&quot;: &quot;2025-04-23T15:42:00Z&quot;,
            &quot;restaurant&quot;: {
                &quot;id&quot;: &quot;b2d5f7a4-3e56-4c1e-9c3b-123456789abc&quot;,
                &quot;inn&quot;: &quot;7728168971&quot;,
                &quot;name&quot;: &quot;Mutabor&quot;,
                &quot;rating&quot;: 4.75,
                &quot;description&quot;: &quot;Современная кухня с авторским подходом&quot;,
                &quot;city&quot;: &quot;Москва&quot;,
                &quot;country&quot;: &quot;Россия&quot;,
                &quot;address&quot;: &quot;ул. Пречистенка, 27&quot;,
                &quot;image_url&quot;: &quot;https://cdn.example.com/announcements/mutabor.jpg&quot;
            }
        }
    ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Произошла ошибка&quot;,
    &quot;error&quot;: &quot;Описание ошибки&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-receipts-history-restaurant" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-receipts-history-restaurant"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-receipts-history-restaurant"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-receipts-history-restaurant" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-receipts-history-restaurant">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-receipts-history-restaurant" data-method="GET"
      data-path="api/receipts/history/restaurant"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-receipts-history-restaurant', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-receipts-history-restaurant"
                    onclick="tryItOut('GETapi-receipts-history-restaurant');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-receipts-history-restaurant"
                    onclick="cancelTryOut('GETapi-receipts-history-restaurant');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-receipts-history-restaurant"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/receipts/history/restaurant</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-receipts-history-restaurant"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-receipts-history-restaurant"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="GETapi-receipts-history-restaurant"
               value="architecto"
               data-component="query">
    <br>
<p>UUID пользователя. Example: <code>architecto</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>restaurant_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="restaurant_id"                data-endpoint="GETapi-receipts-history-restaurant"
               value="architecto"
               data-component="query">
    <br>
<p>UUID ресторана. Example: <code>architecto</code></p>
            </div>
                </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
