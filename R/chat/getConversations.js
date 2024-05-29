getConversations();

function getConversations() {

    fetch('/ws/v1/chat/getConversations.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            UserID: sender.ID,
            internal: "on"
        }),
        credentials: 'include'  // Aggiungi questa linea
    }).then(response => response.json())
        .then(data => {
            setConversations(data.users)
        })
}

function nuovaChat() {
    let email = prompt("Inserisci l'email dell'utente con cui vuoi iniziare una nuova chat");

    fetch('/ws/v1/authentication/getUserID.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            Email: email
        }),
        credentials: 'include'
    }).then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.success == true) {
                window.location.href = "/R/chat?reciver=" + data.UserID;
            } else {
                alert("Utente non trovato");
            }
        })


}



function setConversations(users) {



    let conversations = document.getElementById("conversations");
    conversations.innerHTML = "";

    users.forEach(user => {
        let conversation_a = document.createElement("a");
        conversation_a.href = "/R/chat?reciver=" + user.ID;
        conversation_a.classList.add("list-group-item", "list-group-item-action", "py-3", "lh-sm");


        if (getQuery()["reciver"] == user.ID.toString())
            conversation_a.classList.add("active");
        
            let div1 = document.createElement("div");
            div1.classList.add("d-flex", "w-100", "align-items-center", "justify-content-between");
        
                let name_strong = document.createElement("strong");
                name_strong.classList.add("mb-1");
                name_strong.innerHTML = user.Name + " " + user.Surname;
                div1.appendChild(name_strong);

                let lastsms_small = document.createElement("small");
                lastsms_small.innerHTML = "1 Jan 00:01 am";
                div1.appendChild(lastsms_small);

            conversation_a.appendChild(div1);

            let div2 = document.createElement("div");
            div2.classList.add("col-10", "mb-1", "small", "text-overflow-ellipsis");
            div2.style = "white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
            div2.innerHTML = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam.";
            conversation_a.appendChild(div2);

        conversations.appendChild(conversation_a);

    })

}