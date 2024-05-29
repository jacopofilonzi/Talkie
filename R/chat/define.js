const chat = document.getElementById('chat');
const textArea = document.getElementById('messagetb');

/** Message structure
 * 
 * Author: {
 *     name: string,
 *     surname: string
 *     email: string
 *     }
 * Date: Date
 * Content: string
 */

//Define sender infos
const sender = {
    Name: textArea.getAttribute('data-name'),
    Surname: textArea.getAttribute('data-surname'),
    Email: textArea.getAttribute('data-email'),
    ID: textArea.getAttribute('data-id')
}

var conversations = [];