<?
define('TRO_BUCKETLIST',true);
include('../init.php');
$addStyleSheet[] = templateAddStyleSheet(CSS_URL."/normalize.css");
$addStyleSheet[] = templateAddStyleSheet(CSS_URL."/style.css");
$addScript[] = templateAddScript("https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js");
include(TEMPLATE_DIR . '/header.php');
?>

<!--Category-->
<br><br><br><br><br><br><br><br>
<div class="btn-group btn-group-justified" role="group" aria-label="...">
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-default category" >popular</button>
  </div>
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-default category">hiking</button>
  </div>
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-default category">camping</button>
  </div>
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-default category">shopping</button>
  </div>
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-default category">historic</button>
  </div>
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-default category">cultural</button>
  </div>
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-default category">adventure</button>
  </div>
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-default category">relaxing</button>
  </div>
</div>

 <div ng-controller="MainCtrl as vm" ng-cloak="" ng-app="app" layout="column" layout-fill>
 

  <md-content id="content-scroller">
    <div>
        <div
             class="cards-wrap"
             angular-grid="vm.shots"
             ag-grid-width="300"
             ag-gutter-size="12"
             ag-id="shots"
             ag-infinite-scroll="vm.loadMoreShots()"
             >
          <div class="card" ng-repeat="shot in vm.shots track by $index">
            <!--<div class="img" style="background-image: url({{::shot.image}});"></div>-->
          	<a href="officialBucketList.php?goalID={{::shot.ID}}"><img class="img" src="{{::shot.image}}"></a>
            <div class="inside">
             <a href="officialBucketList.php?goalID={{::shot.ID}}"> <h3>{{::shot.title}}</h3></a>
              <div class="description" ng-bind-html="::shot.description | unsafe"></div>
              <div class="row">
             	<a class="col-md-6 btn btn-default" href="<?echo BASE_URL;?>/test/addGoal.php?goal={{::shot.title}}">Add</a>
             	<a class="col-md-6 btn btn-default" href="<?echo BASE_URL;?>/test/addGoal.php?goal={{::shot.title}}&goalDone=Y">Done</a>
              </div>
            </div>
          </div>
        </div>
        <div class="loading-more-indicator" ng-show="vm.loadingMore">
          <md-progress-circular md-mode="indeterminate" md-diameter="64" class="progress-swatch"></md-progress-circular>
        </div>
    </div>
  </md-content>

</div>


<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-animate.min.js'></script>
<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-route.min.js'></script>
<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-aria.min.js'></script>
<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-messages.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/angular-material/1.0.4/angular-material.js'></script>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/t-114/assets-cache.js'></script>
<script src='../js/angulargrid.min.js'></script>
<script src="../js/index.js"></script>

<?
include(TEMPLATE_DIR . '/footer.php');
?>