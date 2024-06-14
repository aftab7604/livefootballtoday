@extends('PublicArea.layouts.app')
@section('title')
Live Football Today | Articles
@endsection
@section('content')
<?php
if (session('paymentDetailSession')) {
    $userPlanObject = session('paymentDetailSession');
    $userObject = session('userSession');
    $userId = $userObject->id;
    //print_r($userPlanObject);
    if ($userPlanObject && isset($userPlanObject[0]->user_id)) {
        if ($userId == $userPlanObject[0]->user_id) {
        $hasPurchasedPlanss = $userPlanObject[0]->user_id;
        }else{
            $hasPurchasedPlanss = '';
        }
    }else{
        $hasPurchasedPlanss = '';
    }
}else{
    $hasPurchasedPlanss = '';
}

?>
<div class="row mt-3">
    <div class="col-md-12">
        <div class="card align-middle title-band text-white">
            <h5 class="text-left px-2 py-4">Articles</h5>
      
       </div>
       
        <div id="articles_list" class="row">
            <div class="col-md-8">
                <div class="my-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-between">
                                <div class="col-md-6 text-left">
                                    <div class="form-group">
                                        <select class="form-control-sm" name="sorting" id="sorting"
                                            onchange="sort(this.value)">
                                            <option value="desc" {{$sorting == "desc" ? 'selected' : ''}}>Latest
                                            </option>
                                            <option value="asc" {{$sorting == "asc" ? 'selected' : ''}}>Earliest
                                            </option>
                                            <option value="most_clicked"
                                                {{$sorting == "most_clicked" ? 'selected' : ''}}>
                                                Most views
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 text-right">
                                    <div class="form-group">
                                        <select class="form-control-sm" name="filter" id="filter"
                                            onchange="filterCategory(this.value)">
                                            <option value="all" {{$filter == "all" ? 'selected' : ''}}>All</option>
                                            @foreach ($categories as $category)
                                            <option value="{{$category->id}}"
                                                {{$filter == $category->id ? 'selected' : ''}}>
                                                {{$category->title}}
                                            </option>
                                            @endforeach
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <table>
                                        <tbody>
                                            @foreach ($articles as $article)
                                            <tr class="clickable" onclick="showArticle('{{str_replace(' ', '_', $article->title)}}', '{{$article->artical_status}}')">
                                                <td>
                                                    <img src="{{$article->image?asset('uploads/'.$article->image):''}}"
                                                        width=100% alt="article image">
                                                </td>
                                                <td class="special_td text-left">
                                                    <div class="row ml-2 mr-0 px-0">
                                                        <span class="w-100"><?php if(isset($article->artical_status) && $article->artical_status == 'paid'){
                                                           echo '<span class="badge badge-danger float-right py-1 px-2 text-uppercase">'.$article->artical_status.'</span>';
                                                        }else{
                                                          echo '<span class="badge badge-success float-right py-1 px-2 text-uppercase">'.$article->artical_status.'</span>';
                                                        } ?></span>
                                                        <span>
                                                            <h4>{{$article->title}}</h4>
                                                            <span
                                                                class="badge badge-success">{{$article->category?$article->category->title : ''}}</span>&nbsp;<small>{{$article->created_at}}</small>
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="my-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-between">
                                <div class="col-md-12">
                                    <h6 class="text-left">Recommendations</h6>
                                    <table class="mt-4">
                                        <tbody>
                                            @forelse ($recommended_articles as $article)
                                            <tr class="clickable" onclick="showArticle('{{str_replace(' ', '_', $article->title)}}', '{{$article->artical_status}}')">
                                                <td>
                                                    <img class="rec_img"
                                                        src="{{$article->image?asset('uploads/'.$article->image):''}}"
                                                        alt="article image">
                                                </td>
                                                <td class="special_td text-left">
                                                    <div class="row ml-2 mr-0 px-0"> 
                                                        <span class="w-100"><?php if(isset($article->artical_status) && $article->artical_status == 'paid'){
                                                            echo '<span class="badge badge-danger float-right py-1 px-2 text-uppercase">'.$article->artical_status.'</span>';
                                                         }else{
                                                           echo '<span class="badge badge-success float-right py-1 px-2 text-uppercase">'.$article->artical_status.'</span>';
                                                         } ?></span>
                                                        <span>
                                                            <h6 class="article_title">{{$article->title}}</h6>
                                                            <span class="badge badge-success">
                                                                {{$article->category?(strlen($article->category->title) > 12 ? substr($article->category->title, 0, 12).'...' : $article->category->title) : ''}}
                                                            </span>
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
@if ($hasPurchasedPlanss == '') 
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762" crossorigin="anonymous"></script>
<!-- article -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="6210614071"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
@endif

                                            @empty
                                            <tr>
                                                <td colspan="2" class="text-center">
                                                    No Article
                                                </td>
                                            </tr>
                                            @endforelse </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="overlay" id="customOverlay"></div>

<div class="custom-alert" id="customAlert">
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        Please purchase the membership for ads free, betting tips, and to view our articles.
        <a href="{{ url('/articles') }}" class="close">
            <span aria-hidden="true">&times;</span>
        </a>
        <div class="ms_plan">
            <a href="{{ url('/plan') }}" class="btn btn-success">Buy Plan Now</a> 
        </div> 
    </div>
     
</div>

@endsection
@section('js')
<script>
    function showAlert() {
       document.getElementById('customOverlay').style.display = 'block';
       document.getElementById('customAlert').style.display = 'block';
   }
   
   function hideAlert() {
       document.getElementById('customOverlay').style.display = 'none';
       document.getElementById('customAlert').style.display = 'none';
   }
   </script>
<?php
if (session('paymentDetailSession')) {
    $userPlanObject = session('paymentDetailSession');
    if ($userPlanObject && isset($userPlanObject[0]->user_id)) {
        $hasPurchasedPlan = $userPlanObject[0]->user_id;
    }else{
        $hasPurchasedPlan = '';
    }
}else{
    $hasPurchasedPlan = '';
}
if($hasPurchasedPlan && $hasPurchasedPlan != ''){
?>

<script>
function showArticle(title, articleStatus) {
        window.location.href = '{{ url("articles") }}/' + title; 
}
</script>
<?php } else{ ?>
    <script>
function showArticle(title, articleStatus) {
    if (articleStatus === 'free') {
        window.location.href = '{{ url("articles") }}/' + title; 
    } else {
        showAlert();
    }
}    </script>
<?php } ?>
<script>
    var sorting = '{{ $sorting }}';
    var filter = '{{ $filter }}';
    function sort(sort_val) {
        document.cookie = "sorting=" + sort_val;
        document.cookie = "filter=" + filter;
        location.reload();
    }

    function filterCategory(filter_val) {
        document.cookie = "sorting=" + sorting;
        document.cookie = "filter=" + filter_val;
        location.reload();
    }

</script>
@endsection
@section('css')
<style>
    .overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1;
}

.custom-alert {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 2;
}

.alert{
    color: #084298;
  background-color: #cfe2ff;
  border-color: #b6d4fe;
  display: flex;
  align-items: center;
  text-transform: capitalize;
  /* color: #000; */
  padding: 20px 80px;
  list-style: none;
  font-family: Montserrat Alternates;
  font-size: 22px;
  font-weight: 700;
  z-index: 1000;
  height: 250px;
}

.alert a.close{
    position: absolute;
  right: 0;
  top: 0;
}

.alert a.close span{
    font-size: 50px;
    border: 3px solid #9d0303;
  color: #9d0303;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  float: left;
  display: flex; 
  align-items: center;
  justify-content: center;
}

.ms_plan a{
    position: absolute;
  bottom:0;
  text-align: center;
  justify-content: center;
  display: flex;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 200px;
  font-size: 20px;
}

     
    .title-band {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
        url("{{asset('PublicArea/img/article_bg.jpg')}}");
        background-size: cover;
        background-position: center;
    }

    table {
        width: 100%;
    }

    #articles_list {
        min-height: 65vh;
    }

    .card-header {
        background-color: rgba(0, 0, 0, .8);
    }

    .clickable {
        cursor: pointer;
    }

    .special_td {
        width: 76%;
    }

    td {
        padding: 10px;
    }

    tr {
        border-bottom: 0.1px solid rgb(126 126 126 / 28%);
    }

    .rec_img {
        width: 5rem;
    }

    h4,h6{ 
            margin-top: 15px;  
        }

    @media (max-width: 780.98px) {

        .special_td {
            width: 66% !important;
        }
        .custom-alert{
            width: 100%;
        }

        .alert{ 
            font-size: 15px;
        }

        h4,h6{
            font-size: 13px;
            font-weight: 600;  
            margin-top: 15px;  
        }
    }

    @media (max-width: 1024px) {

        .rec_img {
            width: 3rem !important;
        }

        .article_title {
            font-size: 0.8rem !important;
        }
    }

    @media only screen and (max-width:992px){
        .alert{
            width: 100%;
            float: left;
            padding: 20px !important;
        }
    }

</style>
@endsection
