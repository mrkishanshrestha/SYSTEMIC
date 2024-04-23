$( document ).ready(function() {

    juju.alerty({
        position:'top_left',
        status:'success',
        title:'Welcome',
        msg:'To User Search',
    });

    $('#SEARCH_BOX').keyup(function(event){

        var TYPED_DATA = this.value;

        var jackxData = juju.sendJackx({
            URL:'process.php',
            DATA:{SEARCH_DATA:TYPED_DATA}
        });

        jackxData.done(function(data){  
            
            data = JSON.parse(data);
            if(data.ERROR){
                console.log('no data eror');
                $('#friends-container-friends-list').empty();
                $('#friends-container-friends-list').append(`<span style="color:red;font-size:2rem;">No Data Found</span>`);
            }else{
                $('#friends-container-friends-list').empty();
                console.log(data);
                data.forEach(element => {
                    var html = `
                    <div id="friends-list-card" class="friends-list-card">

                        <div id="friends-list-img" class="friends-list-img">
                            <img src="https://scontent.fktm7-1.fna.fbcdn.net/v/t39.30808-1/264673492_3083216861925982_4870591346022152078_n.jpg?stp=dst-jpg_p160x160&_nc_cat=102&ccb=1-5&_nc_sid=7206a8&_nc_ohc=b0Av4ClkB7wAX-NVES8&_nc_ht=scontent.fktm7-1.fna&oh=00_AT9EALW_0NeqxGYN3PtxqeOI0S4m2lYneUh6Sp-ZVKO8PA&oe=62511ECE" alt="">
                        </div>

                        <div id="friends-list-title" class="friends-list-title">
                            <span class="friends-list-title-name">`+element.name+`</span>
                            <span class="friends-list-title-address">`+element.address+`</span>
                            <span class="friends-list-title-mutual">25 Mutual Friends</span>
                        </div>
                
                        <div id="friends-list-setting" class="friends-list-setting">
                        <i class="fa-solid fa-message"></i>
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                
                    </div>`;

                    $('#friends-container-friends-list').append(html);


                });

                var showMore = `
                        <div id="friends-container-friends-loadmore" class="friends-container-friends-loadmore">
                            <a>Show More</a>
                        </div>`;

                $('#friends-container-friends-list').append(showMore);  
            }
        });




    });

});
