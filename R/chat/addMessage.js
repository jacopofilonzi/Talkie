textArea.addEventListener('keypress', sendMessage);
fetchChat();


function sendMessage(e) {

    if (e != null && e.key !== 'Enter') 
        return;


    let content = textArea.value.trim();

    if (content === '')
        return;

    if (content.length > 300)
        return alert('Message is too long! Max 300 characters allowed!');


    let currentDate = new Date();
    let day = currentDate.getDate();
    let month = currentDate.toLocaleString('en-US', { month: 'short' });
    let hours = currentDate.getHours();
    let minutes = currentDate.getMinutes();
    let formattedDate = `${day} ${month} ${hours}:${minutes}`;

    let message = {
        Author: sender,
        Date: formattedDate,
        Content: textArea.value
    }

    sendAPI(textArea.value);
    addMessage(message, true);

    textArea.value = '';
}

function sendAPI(content) {

    fetch('/ws/v1/chat/sendMessage.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            SenderID: sender.ID,
            ReciverID: getQuery()['reciver'],
            Message: content
        }),
        credentials: 'include'
    }).then(response => response.text())
        .then(data => {
            console.log(data);
        })

}

function addMessage(message, isMine) {

    //#region Message header (Author, Date)
    let headerDiv = document.createElement('div');
        headerDiv.classList.add('d-flex', 'justify-content-between');


        let dateP = document.createElement('p');
            dateP.classList.add('small', 'mb-1', 'text-muted');
            dateP.innerText = message.Date;

        let authorP = document.createElement('p');
            authorP.classList.add('small', 'mb-1');
            authorP.innerText = `${message.Author.Name} ${message.Author.Surname}`;

        // if (isMine)
        //     headerDiv.append(dateP, authorP);
        // else
        //     headerDiv.append(authorP, dateP);

    chat.append(headerDiv);
    //#endregion

    //#region Message content
    let messageDiv = document.createElement('div');
        messageDiv.classList.add('d-flex', 'flex-row', 'mb-4', 'pt-1');

        if (isMine)
            messageDiv.classList.add('justify-content-end');
        else
            messageDiv.classList.add('justify-content-start');



        let messageContentDiv = document.createElement('div');

            let messageP = document.createElement('p');
                messageP.classList.add('small', 'p-2', 'me-3', 'mb-3', 'rounded-3');
                messageP.innerText = message.Content;

                if (isMine)
                    messageP.classList.add('bg-primary', 'text-white');
                else
                    messageP.classList.add('bg-white', 'text-dark');


            messageContentDiv.append(messageP);

        messageDiv.append(messageContentDiv);

        chat.append(messageDiv);
        //#endregion

    //Scoll to the bottom
    chat.scrollTop = chat.scrollHeight;
}


/** Return date formatted like "1 Jan 12:00"
 * 
 * @param Date date 
 * @returns string formatted date
 */
function formatDate(date) {
    let day = date.getDate();
    let month = date.toLocaleString('en-US', { month: 'short' });
    let year = date.getFullYear();
    let hours = date.getHours();
    let minutes = date.getMinutes();

    return `${day} ${month} ${year}  ${hours}:${minutes}`;
}



function fetchChat() {
    fetch('/ws/v1/chat/getChat.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            FirstUserID: sender.ID,
            SecondUserID: getQuery()['reciver']
        }),
        credentials: 'include'
    }).then(response => response.json())
        .then(data => {
            chat.innerHTML = "";
            data.forEach(message => {
                addMessage({
                    Author: {
                        Name: message.SenderID == sender.ID ? sender.Name : "name",
                        Surname: message.SenderID == sender.ID ? sender.Surname : "surname",
                    },
                    Date: message.Date,
                    Content: message.Content
                    }, message.SenderID == sender.ID);
                // addMessage(message, message.Author.ID === sender.ID);
            })
        })
}


function fetchNewMessages() {
    fetch('/ws/v1/chat/getNewMessages.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            FirstUserID: sender.ID,
            SecondUserID: getQuery()['reciver']
        }),
        credentials: 'include'
    }).then(response => response.text())
        .then(data => {

            console.log(data)

            data.forEach(message => {
                // addMessage({
                //     Author: {
                //         Name: message.SenderID == sender.ID ? sender.Name : "name",
                //         Surname: message.SenderID == sender.ID ? sender.Surname : "surname",
                //     },
                //     Date: message.Date,
                //     Content: message.Content
                //     }, message.SenderID == sender.ID);
                // addMessage(message, message.Author.ID === sender.ID);
            })
        })
}

setInterval(fetchChat, 1500);