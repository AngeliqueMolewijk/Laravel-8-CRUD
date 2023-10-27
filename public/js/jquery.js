function getImageUrl(element) {
    console.log(element);
    let newname = document.getElementById("newname");
    let newurl = document.getElementById("newurl");

    // newname.value = "";

    let selectedtitle = element.querySelector("#cardid .card-title").innerHTML;
    newname.value = selectedtitle;

    let selectedimage = element.querySelector("#cardid img").src;

    selectedimage.src = element.src;
    newurl.value = selectedimage;
}
