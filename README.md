# 📬 Telegram - VK Notificator Bot

[![Tests](https://github.com/maffinca69/vk-notificator-backend/actions/workflows/test.yml/badge.svg?branch=master)](https://github.com/maffinca69/vk-notificator-backend)

This bot allows you to receive notifications about various events from VK

## 🔔 Available notifications
* Like comment
* Like photo
* Reply on comment
* Acceptng request to friends
* Subscribe for you

## Known issues
* If you like a comment with an attachment in a thread, the attachment will not be sent. [More](https://github.com/maffinca69/vk-notificator-backend/tree/master/app/Services/VK/Comment/CommentGettingService.php#L26)

## Based

Based on Laravel (Lumen) fraemwork 9.1.3, minimum dependencies

## 📃 Docs
* VK API: https://dev.vk.com/method/notifications.get
* Telegram Bot API: https://core.telegram.org/bots/api

## 🔨Tests

* PHPUnit
