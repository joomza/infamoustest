<!DOCTYPE html>

<html>

<head>

	<title>Laravel Vue JS Item CRUD</title>

	<meta id="token" name="token" value="{{ csrf_token() }}">

	<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">

</head>

<body>


	<div class="container" id="manage-vue">

		<div class="row">

		    <div class="col-lg-12 margin-tb">

		        <div class="pull-left">

		            <h2>Laravel Vue JS Info CRUD </h2>

		        </div>

		        <div class="pull-right">

				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-info">

				  Create Info

				</button>

		        </div>

		    </div>

		</div>


		<!-- Item Listing -->

		<table class="table table-bordered">

			<tr>

				<th>Name</th>

				<th>Phone</th>

				<th>Email</th>

				<th>Gender</th>

				<th>Date Of Birth</th>

				<th>Boigraphy</th>

				<th>Photo</th>
				<th width="200px">Action</th>

			</tr>

			<tr v-for="info in infos">

				<td v-if=info.name>@{{ info.name }}</td>

				<td>@{{ info.phone }}</td>

				<td>@{{ info.email }}</td>

				<td>@{{ info.gender }}</td>

				<td>@{{ info.dob }}</td>

				<td>@{{ info.biography }}</td>

				<td><img src="{{url('/')}}/@{{ info.photo }}" alt="image not found" style="width:100%"></td>

				<td>	

			      <button class="btn btn-primary" @click.prevent="editInfo(info)">Edit</button>

			      <button class="btn btn-danger" @click.prevent="deleteInfo(info)">Delete</button>

				</td>

			</tr>

		</table>


		<!-- Pagination -->

		<nav>

	        <ul class="pagination">

	            <li v-if="pagination.current_page > 1">

	                <a href="#" aria-label="Previous"

	                   @click.prevent="changePage(pagination.current_page - 1)">

	                    <span aria-hidden="true">«</span>

	                </a>

	            </li>

	            <li v-for="page in pagesNumber"

	                v-bind:class="[ page == isActived ? 'active' : '']">

	                <a href="#"

	                   @click.prevent="changePage(page)">@{{ page }}</a>

	            </li>

	            <li v-if="pagination.current_page < pagination.last_page">

	                <a href="#" aria-label="Next"

	                   @click.prevent="changePage(pagination.current_page + 1)">

	                    <span aria-hidden="true">»</span>

	                </a>

	            </li>

	        </ul>

	    </nav>


	    <!-- Create Item Modal -->

		<div class="modal fade" id="create-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

		  <div class="modal-dialog" role="document">

		    <div class="modal-content">

		      <div class="modal-header">

		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

		        <h4 class="modal-title" id="myModalLabel">Create Info</h4>

		      </div>

		      <div class="modal-body">


		      		<form method="POST" enctype="multipart/form-data" v-on:submit.prevent="createInfo">


	      			<div class="form-group">

						<label for="name">Name:</label>

						<input type="text" name="name" class="form-control" v-model="newInfo.name" />

						<span v-if="formErrors['name']" class="error text-danger">@{{ formErrors['name'] }}</span>

					</div>
	      			<div class="form-group">

						<label for="phone">Phone:</label>

						<input type="text" name="phone" class="form-control" v-model="newInfo.phone" />

						<span v-if="formErrors['phone']" class="error text-danger">@{{ formErrors['phone'] }}</span>

					</div>
	      			<div class="form-group">

						<label for="phone">email:</label>

						<input type="text" name="email" class="form-control" v-model="newInfo.email" />

						<span v-if="formErrors['email']" class="error text-danger">@{{ formErrors['email'] }}</span>

					</div>
	      			<div class="form-group">
						<label for="gender">Gender:</label>
						  <input type="radio" name="gender" v-model="newInfo.gender" v-bind:value="a">man
						  <input type="radio" name="gender" v-model="newInfo.gender" v-bind:value="b">woman
						  <br />
						  <span v-if="formErrors['gender']" class="error text-danger">@{{ formErrors['gender'] }}</span>
					</div>
	      			<div class="form-group">
						<label for="dob">Date of Birth:</label>

						  <input type="text" name="dob" class="form-control" v-model="newInfo.dob" />
						  <br />
						  <span v-if="formErrors['dob']" class="error text-danger">@{{ formErrors['dob'] }}</span>
					</div>

					<div class="form-group">

						<label for="biography ">Biography :</label>

						<textarea name="biography" class="form-control" v-model="newInfo.biography"></textarea>

						<span v-if="formErrors['biography']" class="error text-danger">@{{ formErrors['biography'] }}</span>

					</div>
					<div class="form-group">

						<label for="photo ">Photo :</label>
						<input type="file" name="photo" class="form-control" v-model="newInfo.photo" @change="imageChanged" />
						<span v-if="formErrors['photo']" class="error text-danger">@{{ formErrors['photo'] }}</span>

					</div>

					<div class="form-group">

						<button type="submit" class="btn btn-success">Submit</button>

					</div>

		      		</form>


		        

		      </div>

		    </div>

		  </div>

		</div>


		<!-- Edit Item Modal -->

		<div class="modal fade" id="edit-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

		  <div class="modal-dialog" role="document">

		    <div class="modal-content">

		      <div class="modal-header">

		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

		        <h4 class="modal-title" id="myModalLabel">Edit Info</h4>

		      </div>

		      <div class="modal-body">


		      		<form method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateInfo(fillInfo.id)">



	      			<div class="form-group">

						<label for="name">Name:</label>

						<input type="text" name="name" class="form-control" v-model="fillInfo.name" />

						<span v-if="formErrorsUpdate['name']" class="error text-danger">@{{ formErrorsUpdate['name'] }}</span>

					</div>
	      			<div class="form-group">

						<label for="phone">Phone:</label>

						<input type="text" name="phone" class="form-control" v-model="fillInfo.phone" />

						<span v-if="formErrorsUpdate['phone']" class="error text-danger">@{{ formErrorsUpdate['phone'] }}</span>

					</div>
	      			<div class="form-group">

						<label for="phone">email:</label>

						<input type="text" name="email" class="form-control" v-model="fillInfo.email" />

						<span v-if="formErrorsUpdate['email']" class="error text-danger">@{{ formErrorsUpdate['email'] }}</span>

					</div>
	      			<div class="form-group">
						<label for="gender">Gender:</label>
						  <input type="radio" name="gender" v-model="fillInfo.gender" v-bind:value="a">Male
						  <input type="radio" name="gender" v-model="fillInfo.gender" v-bind:value="b">Female
						  <?php 
						  	/*var vm = new Vue({
							  el: document.body,
							  data: {
							    a: 0,
							    b: 1
							  }
							})*/
						   ?>
						  
						  <br />
						  <span v-if="formErrorsUpdate['gender']" class="error text-danger">@{{ formErrorsUpdate['gender'] }}</span>
					</div>
	      			<div class="form-group">
						<label for="dob">Date of Birth:</label>
						  <input type="text" name="dob" class="form-control" v-model="fillInfo.dob" />
						  <br />
						  <span v-if="formErrorsUpdate['dob']" class="error text-danger">@{{ formErrorsUpdate['dob'] }}</span>
					</div>

					<div class="form-group">

						<label for="biography ">Biography :</label>

						<textarea name="biography" class="form-control" v-model="fillInfo.biography"></textarea>

						<span v-if="formErrorsUpdate['biography']" class="error text-danger">@{{ formErrorsUpdate['biography'] }}</span>

					</div>
					<div class="form-group">

						<label for="photo ">Photo :</label>

						<input type="file" name="photo"  class="form-control" v-model="fillInfo.photo" @change="imageUpdate" />
						<input type="text" name="" class="form-control" value="@{{fillInfo.photo}}" />
						<span v-if="formErrorsUpdate['photo']" class="error text-danger">@{{ formErrorsUpdate['photo'] }}</span>

					</div>

					<div class="form-group">

						<button type="submit" class="btn btn-success">Submit</button>

					</div>

		      		</form>


		      </div>

		    </div>

		  </div>

		</div>


	</div>

	<script type="text/javascript" src="/js/jquery.min.js"></script>
	<?php 
		//<script type="text/javascript" src="/js/moment.min.js"></script>
	 ?>

	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
	<?php 
		//<script type="text/javascript" src="/js/bootstrap-datetimepicker.min.js"></script>
	 ?>


	<script type="text/javascript" src="/js/toastr.min.js"></script>

    <link href="/css/toastr.min.css" rel="stylesheet">
	<?php 
		//<link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	 ?>

	<script type="text/javascript" src="/js/vue.min.js"></script>

	<script type="text/javascript" src="/js/vue-resource.min.js"></script>
	<?php 
		//<script type="text/javascript" src="/js/vue-bootstrap-datetimepicker.min.js"></script>
	 ?>

	<script type="text/javascript" src="/js/info.js"></script>

</body>

</html>