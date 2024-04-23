document.addEventListener("DOMContentLoaded", function(event) { 


    var cardCount = $("div.notes-card").length;


    var html=`
                        
        <div class="notes-card">

                <div class="notes-card-title">
                    <input type="text" value="Passwords">
                    <i class="fa-solid fa-check"></i>
                </div>

                <div class="notes-card-body">
                    <textarea>Start Writing Here</textarea>
                </div>

                <div class="notes-card-footer">

                        <div class="notes-card-settings" id="notes-card-settings">
                            <i class="fa-solid fa-trash"></i>
                            <i class="fa-solid fa-share-nodes"></i>
                            <i class="fa-solid fa-lock"></i>
                        </div>

                        <i class="fa-solid fa-gear" onclick="this.previousElementSibling.classList.toggle('showme');"></i>
                </div>

        </div>`;

    if(cardCount==0){$('#notes-card-container').append(html);}

    document.getElementById('add-new-note').addEventListener("click", function(event) { 

        

        $('#notes-card-container').append(html);

    });



});