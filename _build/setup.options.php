<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Ivan Klimchuk <ivan@klimchuk.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

$exists = false;
$output = null;

switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        $exists = $modx->getCount('modSystemSetting', array('key:LIKE' => 'slackify_%'));
        break;
}

if ($exists) {
    return;
}

$lexicon = array(
    'ru' => array(
        'title' => 'Настройка Slackify',
        'entrypoint' => 'Ссылка на хук в Slack. Выдается при создании хука',
        'channel' => 'Канал, в который будут отправляться уведомления',
        'info' => 'Вы можете пропустить этот шаг и заполнить эти поля позже в системных настройках.'
    ),
    'en' => array(
        'title' => 'Slackify Settings',
        'entrypoint' => 'Link to hook in Slack. Available after creating of hook',
        'channel' => 'Channel that messages will be sent to',
        'info' => 'You can skip this step and fill this fields later in system settings.'
    ),
    'be' => array(
        'title' => 'Наладка Slackify',
        'entrypoint' => 'Спасылка на хук у Salck. Выдаецца пры стварэнні хука',
        'channel' => 'Канал, у які будуць дасылацца паведамленні',
        'info' => 'Вы можаце прапусціць гэты крок і запоўніць гэтыя палі пазней у сістэмных наладках.'
    )
);

$locale = $modx->getOption('manager_language');
$language = array_key_exists($locale, $lexicon) ? $locale : 'en';
$translate = $lexicon[$language];

$output = <<<HTML
    <style>
        #setup_form_wrapper {font: normal 12px Arial;line-height:18px;}
        #setup_form_wrapper ul {margin-left: 5px; font-size: 10px; list-style: disc inside;}
        #setup_form_wrapper a {color: #08C;}
        #setup_form_wrapper small {font-size: 10px; color:#555; font-style:italic;}
        #setup_form_wrapper label {color: black; font-weight: bold;}
    </style>

    <div id="setup-form-wrapper">
        <h4>{$translate['title']}</h4>

        <label for="slackify-entry-point">{$translate['entrypoint']}</label>
        <input type="text" name="slackify-entry-point" id="slackify-entry-point" width="300" value="" />

        <label for="slackify-channel">{$translate['channel']}</label>
        <input type="text" name="slackify-channel" id="slackify-channel" width="300" value="#general" />

        <small>{$translate['info']}</small>
    </div>
HTML;

return $output;
