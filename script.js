let bankList = []
let users = []

let msgLength = 0
let myName, myPass = ''


//getHash('') // получить хэш ('указать пароль')

$(".log").click(function () { //логин
    log()
})

$("#sendMsg").click(function () {
    sendMsg(myPass)
})


//help function

function getHash(titl) {

    $.ajax({
        url: "getHash.php",
        method: "POST",
        data: {
            title: titl
        },
        success: function (response) {
            // Обработка успешного ответа от сервера
            console.log(response);
        },
        error: function (xhr, status, error) {
            // Обработка ошибок
            console.log(xhr.responseText);
        }
    });
}

//base function

function log() { // логин

    let login = $('.login').val() // получаем логин
    let password = $('.password').val() // получаем пароль

    $.ajax({ // отправляем в php
        url: "log.php",
        method: "POST",
        data: {
            login: login,
            password: password
        },
        success: function (response) { // ответ, после завершения работы Php

            if (response === "Ошибка") { // если в ответе ошибка
                alert('Ошибка')
            }
            else {
                console.log(response)
                let info = response.split('|') // разбиваем ответ в масив
                myName = info[0] // записываем имя
                myPass = password  // пароль
                setInterval(() => getMsg('Messages', myPass), 1000);
            }

        },
        error: function (xhr, status, error) {
            // Обработка ошибок
            console.log(xhr.responseText);
        }
    });

}

function sendMsg(login) { // пишем сообщение

    let title = myName // получаем имя
    let content = $('.text_mes_cont').val() // получаем смс

    $.ajax({
        url: "upd.php",
        method: "POST",
        data: { // отправляем переменные в php
            title: title,
            content: content,
            login: login
        },
        success: function (response) { // ответ, после выполнения php
            console.log(response)
        },
        error: function (xhr, status, error) {
            // Обработка ошибок
            console.log(xhr.responseText);
        }
    });
}

function online(nam) { // узнаем в сети ли пользователь

    let title = 'Дима'
    let content = ''

    if (nam === 1) {
        content = 'ушел'
    }
    else {
        content = 'тут'
    }

    $.ajax({
        url: "upd.php",
        method: "POST",
        data: { // отправляем переменные в php
            title: title,
            content: content
        },
        success: function (response) { // ответ, после выполнения php
            console.log(response);
        },
        error: function (xhr, status, error) {
            // Обработка ошибок
            console.log(xhr.responseText);
        }
    });

}

function getMsg(nam, login) { // вывод сообщений

    let title = myName // получаем имя

    $.ajax({
        url: 'get_msg.php',
        method: 'POST',
        data: {
            table_name: nam,
            title: title,
            login: login
        },
        dataType: 'json',
        success: function (response) {


            if (msgLength < response.data.length) {

                let newMsgCount = response.data.length - msgLength // получаем кол-во новых сообщений
                let reverseData = response.data.reverse() // реверсим масив

                for (let i = 0; i < newMsgCount; i++) { // выводим новые сообщения
                    $('.section').append('<div id="prof">' + reverseData[i].title + '<div id="mes">' + reverseData[i].content + '</div>')
                }

            }

            msgLength = response.data.length // записываем кол-во сообщений
        },
        error: function () {
            console.log('Ошибка при выполнении AJAX-запроса');
        }
    });

}
