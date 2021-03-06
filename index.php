<!DOCTYPE html>
<html lang="en">
<head>
  <title>Stock Monitoring System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./css/bootstrap.min.css">

  <script src="./js/jquery-1.11.1.min.js"></script>
  <script src="./js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>


  <style>
  
  </style>
  
  <script>
   //JQuery Functions MothaFuckas!!!
  $( function() {
  
 
  $("#btn").click(function(){
	//  $("#stockbox").html("loading data...");
	// $.ajax({url: "fetchdata.php", success: function(result){
    //   $("#stockbox").html(result);
    // 
	//}); 
});
  
  
  
  });
  </script
  
  
</head>
<body>

 <!-- This file has been changed online -->
 
 <!-- BAGO na to -->

 <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Portfolio Monitor</a> 
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">Charts</a></li>
 
    
    </ul>
	
	<ul class="nav navbar-nav navbar-right">
      <li> powered by <img src="images/angular.png"/> </li>
     
    </ul>
	
  </div>
  
</nav>
    
	<div class="container"> 
	
	
 
 <button type="button" class="btn btn-primary" id="btn" data-toggle="modal" data-target="#myModal">Add Stock</button>
 
 
<div class="page-wrap" ng-app="myApp" ng-controller="customersCtrl">
 
<table class="table table-striped"> 
	<thead>
	<tr  style="font-weight:bold;"> 
		<td>Ctr</td>
		<td>Symbol</td>
		<td>Current Price</td>
		<td>Ave. Cost</td>
		<td>Shares</td>
		<td>Market Value</td>
		<td>Total Cost</td>
		<td>Gain/Loss</td>
		<td>Percentage</td>
		<td>Stop/Loss</td>
		<td>Target</td>
		<td>Remarks</td>
		<td>Action</td>
	</tr>
	</thead>
	<tbody>


	<tr ng-repeat="x in stocks">

	
		<td>{{ $index + 1 }}</td>
		<td>{{ x.symbol }}</td>
		<td><b>{{ (x.price * 1.00) |number:2 }} </b></td>
		<td>{{ x.aveprice }} </td>
		<td>{{ x.shares |number }}</td>  		
		<td>{{ x.marketvalue |number:2  }} </td> 
		<td>{{ x.totalcost |number:2    }} </td>
		<td style="color:{{x.fcolor}};">{{ 
			  x.gainloss |number:2
		 }}</td>
		<td style="color:{{x.fcolor}};">{{ 
			(( x.gainloss / x.marketvalue ) * 100.00 ) |number:2 }}
		</td>  
		<td> {{ x.stoploss  |number:2 }} </td>  
		<td>{{ x.target |number:2 }}</td>
		<td  style="color:{{x.fcolor}};"> {{x.action}}</td>
		<td> <span class="glyphicon glyphicon-minus-sign" ng-click="DeleteStock(x.symbol)"></span> </td>
	</tr>
   
	</tbody>
</table>




	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Add Stock</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal">
			   <div class="form-group">
				  <label for="sym">Symbol:</label>
				  <input type="text" class="form-control" id="inpSym" ng-model="inputSymbol">
				</div>
				<div class="form-group">
				  <label for="pwd">Shares:</label>
				  <input type="text" class="form-control" id="inpShares" ng-model="inputShares">
				</div>
			   <div class="form-group">
				  <label for="pwd">Average Cost:</label>
				  <input type="text" class="form-control" id="inpAve" ng-model="inputAve">
				</div>
				<button type="submit" class="btn btn-default" ng-click="clickAdd()">Submit</button>
			</form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>

	  </div>
	</div>


</div>
 <div  id="stockbox">
	 
<script>
 
 
	var app = angular.module('myApp', [], function($httpProvider) {
  // Use x-www-form-urlencoded Content-Type
  $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

  /**
   * The workhorse; converts an object to x-www-form-urlencoded serialization.
   * @param {Object} obj
   * @return {String}
   */ 
  var param = function(obj) {
    var query = '', name, value, fullSubName, subName, subValue, innerObj, i;

    for(name in obj) {
      value = obj[name];

      if(value instanceof Array) {
        for(i=0; i<value.length; ++i) {
          subValue = value[i];
          fullSubName = name + '[' + i + ']';
          innerObj = {};
          innerObj[fullSubName] = subValue;
          query += param(innerObj) + '&';
        }
      }
      else if(value instanceof Object) {
        for(subName in value) {
          subValue = value[subName];
          fullSubName = name + '[' + subName + ']';
          innerObj = {};
          innerObj[fullSubName] = subValue;
          query += param(innerObj) + '&';
        }
      }
      else if(value !== undefined && value !== null)
        query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
    }

    return query.length ? query.substr(0, query.length - 1) : query;
  };

  // Override $http service's default transformRequest
  $httpProvider.defaults.transformRequest = [function(data) {
    return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
  }];
});

	
	
	app.controller('customersCtrl', function($scope, $http, $timeout) {
  
 $scope.temp;
	$scope.fetchURL = "fetchdata.php";
	fetchInterval = 20 * 1000;
	//$scope.stopLossPct = 3;
	//$scope.targetPct = 2.5;
	
	$scope.marketVal = 0;
	  // Function to get the data
	  $scope.getData = function(){
		$http.get($scope.fetchURL)
		   .then(function (response) {
		   if(response.data != "0"){
			$scope.stocks = response.data.stock;
			}
		});
	  };

	  // Function to replicate setInterval using $timeout service.
	  $scope.intervalFunction = function(){
		$timeout(function() {
		  $scope.getData();
		  $scope.intervalFunction();
		}, fetchInterval)
	  };

	  // Kick off the interval
	  $scope.intervalFunction();
	   $scope.getData();
	   
	 $scope.clickAdd = function() {
      
		var Indata = {"symbol":$scope.inputSymbol,"shares":$scope.inputShares,"aveprice":$scope.inputAve };
			$http.post("savestock.php", Indata).then(function (data, status, headers, config) { 
				// alert("Stock Saved");
				 location.reload();
			},function (data, status, headers, config) { 
				 
			});
				
    };
	 
	
	$scope.DeleteStock = function(sym) {
    
			var Indata = {"symbol":sym};
			$http.post("deletestock.php", Indata).then(function (data, status, headers, config) { 
				 location.reload();
			},function (data, status, headers, config) { 
				 
			});
				
    };
	     
	   
	   
	});
</script>



	</div>
      
</div>


</body>
</html>
