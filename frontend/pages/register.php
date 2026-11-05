<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="/favicon.png">
    <title>Sign up and start having fun!</title>
    <style>
        * { box-sizing: border-box; }
        html, body { margin: 0; height: 100%; }
        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            background: #0b0d10;
            color: #232527;
        }
        /* The backdrop is a picture of the games wall, so it is one request and one paint instead of
           twenty-four thumbnails the visitor has to wait on. It is only 597px wide, so it is scaled up
           behind a light blur - that reads as a designed wash instead of a soft screenshot. */
        .nx-bg, .nx-bg .art, .nx-bg .shade { position: fixed; inset: 0; }
        .nx-bg { overflow: hidden; z-index: 0; }
        .nx-bg .art {
            inset: -20px;
            background: #0b0d10 url("/img/auth-backdrop.png") center / cover no-repeat;
            filter: blur(2px) saturate(.92) brightness(.96);
        }
        .nx-bg .shade { background: linear-gradient(180deg, rgba(8,10,13,.55), rgba(8,10,13,.72)); }
        .nx-corner { position: fixed; top: 16px; right: 18px; z-index: 3; }
        .nx-corner a {
            display: inline-block;
            background: #fff;
            color: #232527;
            border-radius: 6px;
            padding: 9px 20px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .35);
        }
        .nx-corner a:hover { background: #f0f2f4; }
        .nx-shell {
            position: relative;
            z-index: 2;
            min-height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 72px 16px 32px;
        }
        .nx-logo {
            width: 250px;
            max-width: 62vw;
            margin-bottom: 18px;
            filter: drop-shadow(0 3px 14px rgba(0, 0, 0, .6));
        }
        .nx-card {
            width: 400px;
            max-width: 100%;
            background: #fff;
            border-radius: 10px;
            padding: 26px 26px 28px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .45);
        }
        .nx-title {
            margin: 0 0 18px;
            font-size: 17px;
            font-weight: 800;
            letter-spacing: .3px;
            text-align: center;
            text-transform: uppercase;
            color: #232527;
        }
        .nx-error {
            background: #fdecec;
            border: 1px solid #f3c3c3;
            color: #9d1313;
            border-radius: 6px;
            padding: 10px 12px;
            font-size: 13px;
            line-height: 1.45;
            margin: 0 0 14px;
        }
        .nx-label { display: block; font-size: 13px; font-weight: 700; margin: 16px 0 6px; }
        .nx-input, .nx-bday select {
            width: 100%;
            padding: 11px 12px;
            font-size: 15px;
            font-family: inherit;
            color: #232527;
            background: #fff;
            border: 1px solid #b8bec2;
            border-radius: 6px;
            outline: none;
        }
        .nx-input + .nx-input { margin-top: 14px; }
        .nx-input::placeholder { color: #a9b0b5; }
        .nx-input:focus, .nx-bday select:focus {
            border-color: #335fff;
            box-shadow: 0 0 0 3px rgba(51, 95, 255, .16);
        }
        .nx-bday { display: grid; grid-template-columns: 1.3fr 1fr 1.1fr; gap: 8px; }
        .nx-bday select {
            appearance: none;
            background-image: linear-gradient(45deg, transparent 50%, #7d8389 50%), linear-gradient(135deg, #7d8389 50%, transparent 50%);
            background-position: calc(100% - 16px) calc(50% + 1px), calc(100% - 11px) calc(50% + 1px);
            background-size: 5px 5px, 5px 5px;
            background-repeat: no-repeat;
            padding-right: 26px;
        }
        .nx-hint { font-size: 12px; color: #7d8389; margin: 5px 0 0; }
        .nx-gender { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .nx-gender label {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            height: 84px;
            border: 1px solid #b8bec2;
            border-radius: 8px;
            color: #60656a;
            cursor: pointer;
        }
        .nx-gender label:hover { border-color: #8d949b; background: #fafbfc; }
        .nx-gender input { position: absolute; opacity: 0; pointer-events: none; }
        .nx-gender-name { font-size: 12px; font-weight: 700; letter-spacing: .2px; }
        .nx-gender label:has(input:checked) {
            border-color: #335fff;
            background: #f3f6ff;
            color: #335fff;
            box-shadow: 0 0 0 3px rgba(51, 95, 255, .16);
        }
        .nx-gender label:has(input:focus-visible) {
            border-color: #335fff;
            box-shadow: 0 0 0 3px rgba(51, 95, 255, .35);
        }
        .nx-submit {
            width: 100%;
            margin-top: 22px;
            padding: 13px 12px;
            border: 0;
            border-radius: 6px;
            background: #00b06f;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
        }
        .nx-submit:hover { background: #009a60; }
        .nx-submit:disabled { background: #c7ccd1; color: #f4f5f6; cursor: not-allowed; }
        .nx-terms {
            font-size: 12px;
            color: #7d8389;
            line-height: 1.55;
            text-align: center;
            margin: 16px 0 0;
        }
        .nx-terms a, .nx-alt a { color: #335fff; text-decoration: none; }
        .nx-terms a:hover, .nx-alt a:hover { text-decoration: underline; }
        .nx-alt { font-size: 13px; text-align: center; margin: 14px 0 0; }
        .nx-fine {
            position: relative;
            z-index: 2;
            max-width: 560px;
            margin: 18px auto 0;
            color: #979ea4;
            font-size: 11px;
            line-height: 1.5;
            text-align: center;
        }
        .nx-fine a { color: #b9c0c6; }
    </style>
</head>
<body>
<div class="nx-bg" aria-hidden="true">
    <div class="art"></div>
    <div class="shade"></div>
</div>

<div class="nx-corner">
    <a href="/auth/accountlogin">Log In</a>
</div>

<div class="nx-shell">
    <img class="nx-logo" src="/img/novium-logo.png" alt="Novium">
    <div class="nx-card">
        <h1 class="nx-title">Sign up and start having fun!</h1>
        


<form method="post">
    <label class="nx-label" for="birthMonth">Birthday</label>
    <div class="nx-bday">
        <select id="birthMonth" name="birthMonth" aria-label="Birth month">
            <option value="">Month</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
        </select>
        <select name="birthDay" aria-label="Birth day">
            <option value="">Day</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
        </select>
        <select name="birthYear" aria-label="Birth year">
            <option value="">Year</option>
                <option value="2026">2026</option>
                <option value="2025">2025</option>
                <option value="2024">2024</option>
                <option value="2023">2023</option>
                <option value="2022">2022</option>
                <option value="2021">2021</option>
                <option value="2020">2020</option>
                <option value="2019">2019</option>
                <option value="2018">2018</option>
                <option value="2017">2017</option>
                <option value="2016">2016</option>
                <option value="2015">2015</option>
                <option value="2014">2014</option>
                <option value="2013">2013</option>
                <option value="2012">2012</option>
                <option value="2011">2011</option>
                <option value="2010">2010</option>
                <option value="2009">2009</option>
                <option value="2008">2008</option>
                <option value="2007">2007</option>
                <option value="2006">2006</option>
                <option value="2005">2005</option>
                <option value="2004">2004</option>
                <option value="2003">2003</option>
                <option value="2002">2002</option>
                <option value="2001">2001</option>
                <option value="2000">2000</option>
                <option value="1999">1999</option>
                <option value="1998">1998</option>
                <option value="1997">1997</option>
                <option value="1996">1996</option>
                <option value="1995">1995</option>
                <option value="1994">1994</option>
                <option value="1993">1993</option>
                <option value="1992">1992</option>
                <option value="1991">1991</option>
                <option value="1990">1990</option>
                <option value="1989">1989</option>
                <option value="1988">1988</option>
                <option value="1987">1987</option>
                <option value="1986">1986</option>
                <option value="1985">1985</option>
                <option value="1984">1984</option>
                <option value="1983">1983</option>
                <option value="1982">1982</option>
                <option value="1981">1981</option>
                <option value="1980">1980</option>
                <option value="1979">1979</option>
                <option value="1978">1978</option>
                <option value="1977">1977</option>
                <option value="1976">1976</option>
                <option value="1975">1975</option>
                <option value="1974">1974</option>
                <option value="1973">1973</option>
                <option value="1972">1972</option>
                <option value="1971">1971</option>
                <option value="1970">1970</option>
                <option value="1969">1969</option>
                <option value="1968">1968</option>
                <option value="1967">1967</option>
                <option value="1966">1966</option>
                <option value="1965">1965</option>
                <option value="1964">1964</option>
                <option value="1963">1963</option>
                <option value="1962">1962</option>
                <option value="1961">1961</option>
                <option value="1960">1960</option>
                <option value="1959">1959</option>
                <option value="1958">1958</option>
                <option value="1957">1957</option>
                <option value="1956">1956</option>
                <option value="1955">1955</option>
                <option value="1954">1954</option>
                <option value="1953">1953</option>
                <option value="1952">1952</option>
                <option value="1951">1951</option>
                <option value="1950">1950</option>
                <option value="1949">1949</option>
                <option value="1948">1948</option>
                <option value="1947">1947</option>
                <option value="1946">1946</option>
                <option value="1945">1945</option>
                <option value="1944">1944</option>
                <option value="1943">1943</option>
                <option value="1942">1942</option>
                <option value="1941">1941</option>
                <option value="1940">1940</option>
                <option value="1939">1939</option>
                <option value="1938">1938</option>
                <option value="1937">1937</option>
                <option value="1936">1936</option>
                <option value="1935">1935</option>
                <option value="1934">1934</option>
                <option value="1933">1933</option>
                <option value="1932">1932</option>
                <option value="1931">1931</option>
                <option value="1930">1930</option>
                <option value="1929">1929</option>
                <option value="1928">1928</option>
                <option value="1927">1927</option>
                <option value="1926">1926</option>
        </select>
    </div>

    <input class="nx-input" type="text" placeholder="Username" name="username" maxlength="20"
           autocomplete="username" style="margin-top:14px"/>
    <p class="nx-hint">Don't use your real name</p>

    <input class="nx-input" type="password" placeholder="Password" name="password"
           autocomplete="new-password"/>

    <label class="nx-label">Gender</label>
    <div class="nx-gender">
        <label>
            <input type="radio" name="gender" value="2"/>
            <svg width="22" height="30" viewBox="0 0 22 30" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                <circle cx="11" cy="5" r="3.6"/>
                <path d="M5.4 10.5h11.2l-1.4 8h-2.2l-.5 9h-3l-.5-9H6.8z"/>
            </svg>
            <span class="nx-gender-name">Male</span>
        </label>
        <label>
            <input type="radio" name="gender" value="3"/>
            <svg width="22" height="30" viewBox="0 0 22 30" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                <circle cx="11" cy="5" r="3.6"/>
                <path d="M11 9.2 4.6 21h3.2l-.9 6.4h8.2L14.2 21h3.2z"/>
            </svg>
            <span class="nx-gender-name">Female</span>
        </label>
    </div>

    <input name="__RequestVerificationToken" type="hidden" value="CfDJ8CAqJZMwiVlAmzg30hAqUpjPDhkrF-9oz181tcfDv2cbd_ypbabgnmmtLgyJz9DqFUxLqZeyh4g9LAl9jpf2IxJT3uV_3BwfprSKSRxvLwWNjN12dfrELFfsbpmQU2PzXs7DLypxc6eDXhU8UFexrY8" />

    <p class="nx-terms">
        By clicking Sign Up, you are agreeing to the <a href="/auth/tos" target="_blank" rel="noopener noreferrer">Terms of Use</a>
        and acknowledging the <a href="/auth/privacy" target="_blank" rel="noopener noreferrer">Privacy Policy</a>
    </p>

    <input class="nx-submit" type="submit" value="Sign Up" id="signup-submit"/>
</form>

    </div>
    <p class="nx-fine">
        This website is not affiliated, endorsed, and/or sponsored by any companies, trademarks, or copyrighted
        names mentioned. No copyright infringement is intended. &copy; 2026 <!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="/favicon.png">
    <title>Sign up and start having fun!</title>
    <style>
        * { box-sizing: border-box; }
        html, body { margin: 0; height: 100%; }
        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            background: #0b0d10;
            color: #232527;
        }
        /* The backdrop is a picture of the games wall, so it is one request and one paint instead of
           twenty-four thumbnails the visitor has to wait on. It is only 597px wide, so it is scaled up
           behind a light blur - that reads as a designed wash instead of a soft screenshot. */
        .nx-bg, .nx-bg .art, .nx-bg .shade { position: fixed; inset: 0; }
        .nx-bg { overflow: hidden; z-index: 0; }
        .nx-bg .art {
            inset: -20px;
            background: #0b0d10 url("/img/auth-backdrop.png") center / cover no-repeat;
            filter: blur(2px) saturate(.92) brightness(.96);
        }
        .nx-bg .shade { background: linear-gradient(180deg, rgba(8,10,13,.55), rgba(8,10,13,.72)); }
        .nx-corner { position: fixed; top: 16px; right: 18px; z-index: 3; }
        .nx-corner a {
            display: inline-block;
            background: #fff;
            color: #232527;
            border-radius: 6px;
            padding: 9px 20px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .35);
        }
        .nx-corner a:hover { background: #f0f2f4; }
        .nx-shell {
            position: relative;
            z-index: 2;
            min-height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 72px 16px 32px;
        }
        .nx-logo {
            width: 250px;
            max-width: 62vw;
            margin-bottom: 18px;
            filter: drop-shadow(0 3px 14px rgba(0, 0, 0, .6));
        }
        .nx-card {
            width: 400px;
            max-width: 100%;
            background: #fff;
            border-radius: 10px;
            padding: 26px 26px 28px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .45);
        }
        .nx-title {
            margin: 0 0 18px;
            font-size: 17px;
            font-weight: 800;
            letter-spacing: .3px;
            text-align: center;
            text-transform: uppercase;
            color: #232527;
        }
        .nx-error {
            background: #fdecec;
            border: 1px solid #f3c3c3;
            color: #9d1313;
            border-radius: 6px;
            padding: 10px 12px;
            font-size: 13px;
            line-height: 1.45;
            margin: 0 0 14px;
        }
        .nx-label { display: block; font-size: 13px; font-weight: 700; margin: 16px 0 6px; }
        .nx-input, .nx-bday select {
            width: 100%;
            padding: 11px 12px;
            font-size: 15px;
            font-family: inherit;
            color: #232527;
            background: #fff;
            border: 1px solid #b8bec2;
            border-radius: 6px;
            outline: none;
        }
        .nx-input + .nx-input { margin-top: 14px; }
        .nx-input::placeholder { color: #a9b0b5; }
        .nx-input:focus, .nx-bday select:focus {
            border-color: #335fff;
            box-shadow: 0 0 0 3px rgba(51, 95, 255, .16);
        }
        .nx-bday { display: grid; grid-template-columns: 1.3fr 1fr 1.1fr; gap: 8px; }
        .nx-bday select {
            appearance: none;
            background-image: linear-gradient(45deg, transparent 50%, #7d8389 50%), linear-gradient(135deg, #7d8389 50%, transparent 50%);
            background-position: calc(100% - 16px) calc(50% + 1px), calc(100% - 11px) calc(50% + 1px);
            background-size: 5px 5px, 5px 5px;
            background-repeat: no-repeat;
            padding-right: 26px;
        }
        .nx-hint { font-size: 12px; color: #7d8389; margin: 5px 0 0; }
        .nx-gender { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .nx-gender label {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            height: 84px;
            border: 1px solid #b8bec2;
            border-radius: 8px;
            color: #60656a;
            cursor: pointer;
        }
        .nx-gender label:hover { border-color: #8d949b; background: #fafbfc; }
        .nx-gender input { position: absolute; opacity: 0; pointer-events: none; }
        .nx-gender-name { font-size: 12px; font-weight: 700; letter-spacing: .2px; }
        .nx-gender label:has(input:checked) {
            border-color: #335fff;
            background: #f3f6ff;
            color: #335fff;
            box-shadow: 0 0 0 3px rgba(51, 95, 255, .16);
        }
        .nx-gender label:has(input:focus-visible) {
            border-color: #335fff;
            box-shadow: 0 0 0 3px rgba(51, 95, 255, .35);
        }
        .nx-submit {
            width: 100%;
            margin-top: 22px;
            padding: 13px 12px;
            border: 0;
            border-radius: 6px;
            background: #00b06f;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
        }
        .nx-submit:hover { background: #009a60; }
        .nx-submit:disabled { background: #c7ccd1; color: #f4f5f6; cursor: not-allowed; }
        .nx-terms {
            font-size: 12px;
            color: #7d8389;
            line-height: 1.55;
            text-align: center;
            margin: 16px 0 0;
        }
        .nx-terms a, .nx-alt a { color: #335fff; text-decoration: none; }
        .nx-terms a:hover, .nx-alt a:hover { text-decoration: underline; }
        .nx-alt { font-size: 13px; text-align: center; margin: 14px 0 0; }
        .nx-fine {
            position: relative;
            z-index: 2;
            max-width: 560px;
            margin: 18px auto 0;
            color: #979ea4;
            font-size: 11px;
            line-height: 1.5;
            text-align: center;
        }
        .nx-fine a { color: #b9c0c6; }
    </style>
</head>
<body>
<div class="nx-bg" aria-hidden="true">
    <div class="art"></div>
    <div class="shade"></div>
</div>

<div class="nx-corner">
    <a href="/auth/accountlogin">Log In</a>
</div>

<div class="nx-shell">
    <img class="nx-logo" src="/img/novium-logo.png" alt="Novium">
    <div class="nx-card">
        <h1 class="nx-title">Sign up and start having fun!</h1>
        


<form method="post">
    <label class="nx-label" for="birthMonth">Birthday</label>
    <div class="nx-bday">
        <select id="birthMonth" name="birthMonth" aria-label="Birth month">
            <option value="">Month</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
        </select>
        <select name="birthDay" aria-label="Birth day">
            <option value="">Day</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
        </select>
        <select name="birthYear" aria-label="Birth year">
            <option value="">Year</option>
                <option value="2026">2026</option>
                <option value="2025">2025</option>
                <option value="2024">2024</option>
                <option value="2023">2023</option>
                <option value="2022">2022</option>
                <option value="2021">2021</option>
                <option value="2020">2020</option>
                <option value="2019">2019</option>
                <option value="2018">2018</option>
                <option value="2017">2017</option>
                <option value="2016">2016</option>
                <option value="2015">2015</option>
                <option value="2014">2014</option>
                <option value="2013">2013</option>
                <option value="2012">2012</option>
                <option value="2011">2011</option>
                <option value="2010">2010</option>
                <option value="2009">2009</option>
                <option value="2008">2008</option>
                <option value="2007">2007</option>
                <option value="2006">2006</option>
                <option value="2005">2005</option>
                <option value="2004">2004</option>
                <option value="2003">2003</option>
                <option value="2002">2002</option>
                <option value="2001">2001</option>
                <option value="2000">2000</option>
                <option value="1999">1999</option>
                <option value="1998">1998</option>
                <option value="1997">1997</option>
                <option value="1996">1996</option>
                <option value="1995">1995</option>
                <option value="1994">1994</option>
                <option value="1993">1993</option>
                <option value="1992">1992</option>
                <option value="1991">1991</option>
                <option value="1990">1990</option>
                <option value="1989">1989</option>
                <option value="1988">1988</option>
                <option value="1987">1987</option>
                <option value="1986">1986</option>
                <option value="1985">1985</option>
                <option value="1984">1984</option>
                <option value="1983">1983</option>
                <option value="1982">1982</option>
                <option value="1981">1981</option>
                <option value="1980">1980</option>
                <option value="1979">1979</option>
                <option value="1978">1978</option>
                <option value="1977">1977</option>
                <option value="1976">1976</option>
                <option value="1975">1975</option>
                <option value="1974">1974</option>
                <option value="1973">1973</option>
                <option value="1972">1972</option>
                <option value="1971">1971</option>
                <option value="1970">1970</option>
                <option value="1969">1969</option>
                <option value="1968">1968</option>
                <option value="1967">1967</option>
                <option value="1966">1966</option>
                <option value="1965">1965</option>
                <option value="1964">1964</option>
                <option value="1963">1963</option>
                <option value="1962">1962</option>
                <option value="1961">1961</option>
                <option value="1960">1960</option>
                <option value="1959">1959</option>
                <option value="1958">1958</option>
                <option value="1957">1957</option>
                <option value="1956">1956</option>
                <option value="1955">1955</option>
                <option value="1954">1954</option>
                <option value="1953">1953</option>
                <option value="1952">1952</option>
                <option value="1951">1951</option>
                <option value="1950">1950</option>
                <option value="1949">1949</option>
                <option value="1948">1948</option>
                <option value="1947">1947</option>
                <option value="1946">1946</option>
                <option value="1945">1945</option>
                <option value="1944">1944</option>
                <option value="1943">1943</option>
                <option value="1942">1942</option>
                <option value="1941">1941</option>
                <option value="1940">1940</option>
                <option value="1939">1939</option>
                <option value="1938">1938</option>
                <option value="1937">1937</option>
                <option value="1936">1936</option>
                <option value="1935">1935</option>
                <option value="1934">1934</option>
                <option value="1933">1933</option>
                <option value="1932">1932</option>
                <option value="1931">1931</option>
                <option value="1930">1930</option>
                <option value="1929">1929</option>
                <option value="1928">1928</option>
                <option value="1927">1927</option>
                <option value="1926">1926</option>
        </select>
    </div>

    <input class="nx-input" type="text" placeholder="Username" name="username" maxlength="20"
           autocomplete="username" style="margin-top:14px"/>
    <p class="nx-hint">Don't use your real name</p>

    <input class="nx-input" type="password" placeholder="Password" name="password"
           autocomplete="new-password"/>

    <label class="nx-label">Gender</label>
    <div class="nx-gender">
        <label>
            <input type="radio" name="gender" value="2"/>
            <svg width="22" height="30" viewBox="0 0 22 30" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                <circle cx="11" cy="5" r="3.6"/>
                <path d="M5.4 10.5h11.2l-1.4 8h-2.2l-.5 9h-3l-.5-9H6.8z"/>
            </svg>
            <span class="nx-gender-name">Male</span>
        </label>
        <label>
            <input type="radio" name="gender" value="3"/>
            <svg width="22" height="30" viewBox="0 0 22 30" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                <circle cx="11" cy="5" r="3.6"/>
                <path d="M11 9.2 4.6 21h3.2l-.9 6.4h8.2L14.2 21h3.2z"/>
            </svg>
            <span class="nx-gender-name">Female</span>
        </label>
    </div>

    <input name="__RequestVerificationToken" type="hidden" value="CfDJ8CAqJZMwiVlAmzg30hAqUpjPDhkrF-9oz181tcfDv2cbd_ypbabgnmmtLgyJz9DqFUxLqZeyh4g9LAl9jpf2IxJT3uV_3BwfprSKSRxvLwWNjN12dfrELFfsbpmQU2PzXs7DLypxc6eDXhU8UFexrY8" />

    <p class="nx-terms">
        By clicking Sign Up, you are agreeing to the <a href="/auth/tos" target="_blank" rel="noopener noreferrer">Terms of Use</a>
        and acknowledging the <a href="/auth/privacy" target="_blank" rel="noopener noreferrer">Privacy Policy</a>
    </p>

    <input class="nx-submit" type="submit" value="Sign Up" id="signup-submit"/>
</form>

    </div>
    <p class="nx-fine">
        This website is not affiliated, endorsed, and/or sponsored by any companies, trademarks, or copyrighted
        names mentioned. No copyright infringement is intended. &copy; 2026 Project Pekora
    </p>
</div>
<script src="/pek-device.js"></script><script type="module" src="https://static.cloudflareinsights.com/beacon.min.js/vce701823e78c4301a35b7e07294d87301792088814092" integrity="sha512-UKNk8GbxkABxKcXYuLkO16EleLGUkcvJWtpSNmExE0Too3ZaFAxTscNWEc1OdAv5/BikHawapSCaiD2XCmp+Bw==" data-cf-beacon='{"version":"2024.11.0","token":"613680659ec04c24a15d482cf9b75dd1","r":1,"spa":2}' crossorigin="anonymous"></script>
</body>
</html>
    </p>
</div>
<script src="/pek-device.js"></script><script type="module" src="https://static.cloudflareinsights.com/beacon.min.js/vce701823e78c4301a35b7e07294d87301792088814092" integrity="sha512-UKNk8GbxkABxKcXYuLkO16EleLGUkcvJWtpSNmExE0Too3ZaFAxTscNWEc1OdAv5/BikHawapSCaiD2XCmp+Bw==" data-cf-beacon='{"version":"2024.11.0","token":"613680659ec04c24a15d482cf9b75dd1","r":1,"spa":2}' crossorigin="anonymous"></script>
</body>
</html>
