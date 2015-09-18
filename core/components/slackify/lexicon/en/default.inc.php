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

$_lang['setting_slackify_entrypoint'] = 'Entry Point';
$_lang['setting_slackify_entrypoint_desc'] = 'Url to Slack incoming web-hook';

$_lang['setting_slackify_channel'] = 'Default channel';
$_lang['setting_slackify_channel_desc'] = 'The default channel that messages will be sent to';

$_lang['setting_slackify_username'] = 'Sender';
$_lang['setting_slackify_username_desc'] = 'The default username that messages will be sent from. If empty will be used site_name setting';

$_lang['setting_slackify_icon'] = 'Icon';
$_lang['setting_slackify_icon_desc'] = 'The default icon messages will be sent with, either :emoji: or a URL to an image';

$_lang['setting_slackify_link_names'] = 'Names with links';
$_lang['setting_slackify_link_names_desc'] = 'Whether names like @regan or #accounting should be linked';

$_lang['setting_slackify_unfurl_links'] = 'Unfurl URLs';
$_lang['setting_slackify_unfurl_links_desc'] = 'Whether Slack should unfurl text-based URLs';

$_lang['setting_slackify_unfurl_media'] = 'Unfurl Media';
$_lang['setting_slackify_unfurl_media_desc'] = 'Whether Slack should unfurl media-based URLs';

$_lang['setting_slackify_allow_markdown'] = 'Use Markdown';
$_lang['setting_slackify_allow_markdown_desc'] = 'Whether Markdown should be parsed in messages';

$_lang['setting_slackify_markdown_in_attachments'] = 'Attachment field with Markdown';
$_lang['setting_slackify_markdown_in_attachments_desc'] = 'Which attachment fields should have Markdown parsed';
