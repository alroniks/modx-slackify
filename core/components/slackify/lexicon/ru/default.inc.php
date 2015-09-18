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

$_lang['setting_slackify_entrypoint'] = 'Точка входа';
$_lang['setting_slackify_entrypoint_desc'] = 'Ссылка на входной web-hook в Slack';

$_lang['setting_slackify_channel'] = 'Канал';
$_lang['setting_slackify_channel_desc'] = 'Канал по умолчанию, в который будут отправляться сообщения';

$_lang['setting_slackify_username'] = 'Отправитель';
$_lang['setting_slackify_username_desc'] = 'Имя пользователя по умолчанию, от которого будут отправляться сообщения. Если пусто, будет использоваться системная настройка site_name';

$_lang['setting_slackify_icon'] = 'Иконка';
$_lang['setting_slackify_icon_desc'] = 'Иконка по умолчанию, с которой будет отправляться сообщение; может быть ссылкой на картинку или :emoji:';

$_lang['setting_slackify_link_names'] = 'Имена с ссылками';
$_lang['setting_slackify_link_names_desc'] = 'Показывать @regan или #accounting ссылками';

$_lang['setting_slackify_unfurl_links'] = 'Обрабатывать обычные ссылки';
$_lang['setting_slackify_unfurl_links_desc'] = 'Slack будет подтягивать информацию по ссылке, как Facebook';

$_lang['setting_slackify_unfurl_media'] = 'Обрабатывать ссылки на медиа';
$_lang['setting_slackify_unfurl_media_desc'] = 'Slack будет подтягивать медиа-контент по ссылке';

$_lang['setting_slackify_allow_markdown'] = 'Использовать Markdown';
$_lang['setting_slackify_allow_markdown_desc'] = 'Slack будет парсить Markdown в сообщениях';

$_lang['setting_slackify_markdown_in_attachments'] = 'Markdown в прикреплениях';
$_lang['setting_slackify_markdown_in_attachments_desc'] = 'Список полей в прикреплениях, в которых нужно парсить Markdown';
