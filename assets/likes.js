document.querySelector('#like').addEventListener('click', (event) => {
    event.preventDefault();
    let likelink = event.currentTarget;
    let link = likelink.href;
    fetch(link)
        .then(response => response.json())
        .then(function (response){
            let linkIcon = likelink.firstElementChild;
            if (response.isLiked){
                linkIcon.name = 'heart'
            }else {
                linkIcon.name ='heart-outline';
            }
            console.log(linkIcon.name);
        });
})
