<?php
	require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $kali->link('GLOBAL_DESIGN');
    $kali->link('JQUERY');
    $kali->link('GLOBAL_SCRIPT');
    $kali->link('KALI_FORM');
    $kali->link('ASSETS');
    $kali->link('TABLE');
    $kali->link('BOOTSTRAP');
?>
<body>

<div class="kali-inputbox">
	<input type="search" id="SEARCH_BOX" name="SEARH_BOX" placeholder="Search User Here">
</div>

<div id="datacard-container" class="datacard-container">
	<div id="data-container-body" class="data-container-body">
	</div>
</div>

<div id="data_contents">
</div>

<div id="modals_container">
</div>


<script>

	function updateNow(thisObj){

			let counterVariable = thisObj.id;

			var data = {COUNTER:counterVariable,
				ATTR:['selfid','name','short_name','address','geo_location','contact_number','phone_number','email','affiliation','description','est_date','college_logo','college_background_image','domain_cname']};

			var jsonDataCollection = juju.jDataGather(data,true);
			jsonDataCollection.update='update';

			var jackxData = juju.sendJackx({
                URL:'process.php',
                DATA: jsonDataCollection
            });

            jackxData.done(function(data){  
				data=JSON.parse(data);
                if(data.ERROR){
                    juju.alerty({
                        status:'danger',
                        msg:data.MSG,
                        title:'ERROR',
                        position:'top_right'
                    });
				}else{
                    juju.alerty({
                        status:'success',
                        msg:data.MSG,
                        title:'Hurray',
                        position:'top_right'
                    });

					$('#'+counterVariable).hide();
                }
            });


	}

	function createModal(MySelfId){

		juju.makeModal({
						IDNAME:'LOGO_CHANGE_MODAL',
						TITLE:'Upload New Logo',
						BODY:`<div class="dropzone">
								<div ><span onclick="$()">Click Yo Chose Files `+MySelfId+`<input type="file" id="COLLEGE_LOGO" name="COLLEGE_LOGO"></span></div>
							</div>`,
						FUNCTION:"updateImage('COLLEGE_LOGO');",
						APPEND_TO:'modals_container',
						TYPE:'FORM',
						FORM_ID:'IMG_UPDATE_FORM'
					});


					$("#IMG_UPDATE_FORM").submit(function(event){
						
						event.preventDefault();
						var jackxData = juju.sendJackx({
							URL:'process.php',
							FORM: this,
							DATA:{SELFID:MySelfId}
					});

		});

		juju.bootModal('show','LOGO_CHANGE_MODAL');

		$('#LOGO_CHANGE_MODAL').on('hidden.bs.modal',function(event){
			$('#LOGO_CHANGE_MODAL').remove();
		})

	}

	$( document ).ready(function() {

		juju.alerty({
			position:'bottom_left',
			status:'success',
			title:'Welcome',
			msg:'To User Search',
			sound:true,
		});

        $('#SEARCH_BOX').keyup(function(event){

				var jackxData = juju.postJackx('process.php',{SEARCH_DATA: this.value});

				jackxData.done(function(data){
					
					if(data=='""' || data=="null"){$("#data_contents").empty();return true;}

					data=JSON.parse(data);
					$("#data_contents").empty();
					if(data.ERROR){ $('#data_contents').append(`<h1 style="color:red;">No Data Found</h1>`); }

					var counter =1;
					
					var TableBody = `<table>
								<thead>
									<tr>
									<th scope="col">Logo</th>
									<th scope="col">College Name</th>
									<th scope="col">Short Name</th>
									<th scope="col">Address</th>
									<th scope="col">Geo Location</th>
									<th scope="col">Contact</th>
									<th scope="col">Secondary Contact</th>
									<th scope="col">Domain Cname</th>
									<th scope="col">Email</th>
									<th scope="col">Affiliation</th>
									<th scope="col">Description</th>
									<th scope="col">Est Date</th>
									<th scope="col">Background</th>
									</tr>
								</thead>
								<tbody id="table_contents">`;

							data.forEach(element => {
								var state = '';
								if(element.status=='DEACTIVE'){state = 'selected';}

								college_logo_dir = "http://systemic.com/CLIENTS/COLLEGES/"+element.domain_cname+'/IMG/'+element.college_logo;
								college_background_dir = "http://systemic.com/CLIENTS/COLLEGES/"+element.domain_cname+'/IMG/'+element.college_background_image;
								
								TableBody+=`
											<tr>
												<td data-label="Photo">
													<input type="text" id="selfid-`+counter+`" value="`+element.id+`" style="display:none;">
													<img ondblclick="createModal('`+element.id+`');" id="college_logo-`+counter+`"  src="`+college_logo_dir+`" alt="LOGO" height="600">
												</td>
												
												<td data-label="Username">
													<textarea type="text" id="name-`+counter+`"  ondblclick="juju.makeWriteable(this);"  style="color:black;background:none;"  readonly>`+element.name+`</textarea>
												</td>

												<td data-label="Name">
													<textarea type="text" id="short_name-`+counter+`"  ondblclick="juju.makeWriteable(this);"  style="color:black;background:none;" readonly>`+element.short_name+`</textarea>
												</td>

												<td data-label="Address">
													<textarea type="text" id="address-`+counter+`"  ondblclick="juju.makeWriteable(this);"  style="color:black;background:none;"  readonly>`+element.address+`</textarea>
												</td>

												<td data-label="Email">
													<textarea type="email" id="geo_location-`+counter+`"  ondblclick="juju.makeWriteable(this);"  style="color:black;background:none;"  readonly>`+element.geo_location+`</textarea>
												</td>

												<td data-label="Contact">
													<textarea type="text" id="contact_number-`+counter+`"  ondblclick="juju.makeWriteable(this);"  style="color:black;background:none;"  readonly>`+element.contact_number+`</textarea>
												</td>

												<td data-label="Secondary Contact">
													<textarea type="text" id="phone_number-`+counter+`"  ondblclick="juju.makeWriteable(this);"  style="color:black;background:none;" readonly>`+element.phone_number+`</textarea>
												</td>

												<td data-label="Domain Cname">
													<textarea type="text" id="domain_cname-`+counter+`"  ondblclick="juju.makeWriteable(this);"  style="color:black;background:none;" readonly>`+element.domain_cname+`</textarea>
												</td>

												<td data-label="Email">
													<textarea type="text" id="email-`+counter+`"  ondblclick="juju.makeWriteable(this);"  style="color:black;background:none;"  readonly>`+element.email+`</textarea>
												</td>
	
												<td data-label="Affiliation">
													<textarea type="text" id="affiliation-`+counter+`"  ondblclick="juju.makeWriteable(this);"  style="color:black;background:none;" readonly>`+element.affiliation+`</textarea>
												</td>
	
												<td data-label="Description">
													<textarea type="text" id="description-`+counter+`"  ondblclick="juju.makeWriteable(this);"  style="color:black;background:none;" readonly>`+element.description+`</textarea>
												</td>
	
												<td data-label="Est Date">
													<textarea type="text" id="est_date-`+counter+`"  ondblclick="juju.makeWriteable(this);"  style="color:black;background:none;" readonly>`+element.est_date+`</textarea>
												</td>
	
												<td data-label="Client Status">
														<img ondblclick="alert('chaning image');"  id="college_background_image-`+counter+`"  src="`+college_background_dir+`" alt="Girl in a jacket" width="500" height="600">
													<div>
														<input type="submit" id="`+counter+`" onclick="updateNow(this);" style="display: none;" value="Save Changes" class="edit-button">
													</div>	
												</td>

											</tr>`;

										counter++;

									}); // loop 

									TableBody+=`</tbody>
												</table>`;

									$('#data_contents').append(TableBody);
				
				}); // juju done

		});// event on keyup

	}); // document ready

</script>


</body>
