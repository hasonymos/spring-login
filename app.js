function _(id) {
    return document.getElementById(id);
}

function $(className) {
    return document.getElementsByClassName(className)
}

const MOB_NAV = _("headerNav")
const MOB_MENU = $("navBtn")
const CLOSE_BTN = $("closeBtn")


var loader = _("loader")
loader.style.display = "none"

var contactForm = _("contactForm")
contactForm.addEventListener("submit", async (evt) => {
    evt.preventDefault()
    let form = new FormData(contactForm)
    form.append("contact", 1)

    let response = await fetch("server.php", {
        method: "POST",
        body: form
    })

    let json = await response.json();
    if(json.message === "Email sent") {
        _("contactName").value = ""
        _("contactEmail").value = ""
        _("subject").value = ""
        _("msg").value = ""
    }

})


MOB_MENU[2].addEventListener("click", (evt) => {
    evt.preventDefault()
    MOB_NAV.style.display = "block"
})

for(let i = 0; i < CLOSE_BTN.length; i++) {
    CLOSE_BTN[i].addEventListener("click", (evt) => {
        evt.preventDefault()
        let elem = CLOSE_BTN[i].parentElement
        elem.style.display = "none"
    })
}

async function getPosts() {
    let form = new FormData()
    form.append("getPosts", 1)
    let response = await fetch("server.php", {
        method: "POST",
        body: form
    })
    let result = await response.json()
    for(let i = 0; i < result.length; i++) {
        let postItem = document.createElement("div")
        postItem.setAttribute("class", "postItem")
        let img = document.createElement("img")
        img.src = `img/${result[i].image}`
        let caption = document.createElement("div")
        caption.setAttribute("id", "caption")
        let h3 = document.createElement("h3")
        h3.innerHTML = result[i].title
        caption.appendChild(h3)
        postItem.appendChild(img)
        postItem.appendChild(caption)
        _("postsDiv").appendChild(postItem)
    }
    console.log(result)
}

getPosts()