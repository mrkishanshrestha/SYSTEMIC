
<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Hello World</title>
</head>
<body>

	<style type="text/css">

		::-webkit-scrollbar {
		  width: 1px;
		}

		*{
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			scrollbar-width: thin;
		}

		.datacard-container{
			border: 1px solid red;
			width: fit-content;
		}

		.data-container-body{
			display: flex;
			align-items: center;
		}

		.data-title-container{
			border: 1px solid yellow;
		}

		.datacard-image{
			height: 255px;
			width: 255px;
			border-radius: 50%;
			padding: 0.5rem;

		}

		.data-title-container{
			width: auto;
		}

		.data-content-container{
			display: flex;
			flex-direction: column;
			padding: 1.2rem;
			width: 420px;

		}

		.data-context-container{
			border: 1px solid blue;
			font-size: 1.7rem;
			display: block;
      		height: 185px;
			overflow-y: auto;  /* <---------- required */
		}

		.data-footer-container{
			margin-top: 1rem;
			border: 1px solid blue;
			font-size: 1.7rem;
			display: flex;
			width: 100%;
			flex-direction: row;
			gap: 0.7rem;
			justify-content: end;
		}

		.data-contents{

			width: auto;
			font-size: 1.7rem;
			display: flex;

			flex-direction: column;
			gap: 0.7rem;
			justify-content: center;

		}


		.data-more-container{
			border: 2px solid green;
			height: 200px;
			padding: 1.2rem;
		}

		.data-more-body-container{
			padding: 1rem;
			border: 2px solid green;
		}

		.data-content{
			border: 2px solid green;
			display: flex;
			justify-content: space-between;
			padding-left: 1rem;
			padding-right: 1rem;
		}


	</style>

	<h1>Hello World</h1>

	<div id="datacard-container" class="datacard-container">

		<div id="data-container-body" class="data-container-body">

			<div class="data-title-container">
				<img class="datacard-image"
				src="https://scontent.fktm7-1.fna.fbcdn.net/v/t39.30808-6/264673492_3083216861925982_4870591346022152078_n.jpg?_nc_cat=102&ccb=1-5&_nc_sid=09cbfe&_nc_ohc=v_RXrFw3XrcAX8fF0W8&_nc_ht=scontent.fktm7-1.fna&oh=00_AT-FcEKf_tu5fGjsq5coRhgBjYkv22dyz-cg-L2NjqFaXQ&oe=62447190">
			</div>

			<div class="data-content-container">

					<div class="data-context-container">
						<div class="data-contents">
							

							<div class="data-content">
								<label>Username:</label>
								<input type="text" value="KALI">
							</div>

							<div class="data-content">
								<label>Name:</label>
								<span>KisHan ShrEstha</span>
							</div>

							<div class="data-content">
								<label>Address:</label>
								<span>Bafal</span>
							</div>	

							<div class="data-content">
								<label>Contact:</label>
								<span>+977-9860050358</span>
							</div>	

							<div class="data-content">
								<label>Contact:</label>
								<span>+977-9860050358</span>
							</div>

							<div class="data-content">
								<label>Contact:</label>
								<span>+977-9860050358</span>
							</div>	

							<div class="data-content">
								<label>Contact:</label>
								<span>+977-9860050358</span>
							</div>	

							<div class="data-content">
								<label>Contact:</label>
								<span>+977-9860050358</span>
							</div>	

							<div class="data-content">
								<label>Contact:</label>
								<span>+977-9860050358</span>
							</div>	

							<div class="data-content">
								<label>Contact:</label>
								<span>+977-9860050358</span>
							</div>	

							<div class="data-content">
							<img class="datacard-image"
				src="https://scontent.fktm7-1.fna.fbcdn.net/v/t39.30808-6/264673492_3083216861925982_4870591346022152078_n.jpg?_nc_cat=102&ccb=1-5&_nc_sid=09cbfe&_nc_ohc=v_RXrFw3XrcAX8fF0W8&_nc_ht=scontent.fktm7-1.fna&oh=00_AT-FcEKf_tu5fGjsq5coRhgBjYkv22dyz-cg-L2NjqFaXQ&oe=62447190">
							</div>	

							<div class="data-content">
								<label>Contact:</label>
								<span>+977-9860050358</span>
							</div>	

							<div class="data-content">
								<label>Contact:</label>
								<span>+977-9860050358</span>
							</div>	

							<div class="data-content">
								<label>Contact:</label>
								<span>+977-9860050358</span>
							</div>	

						</div>
					</div>

					<div class="data-footer-container">
						
						<div>
							<button>Edit</button>
						</div>	
						
						<div>
							<button>Edit</button>
						</div>	

					</div>

			</div>
		</div>

		</div>


	</div>



</body>
</html>