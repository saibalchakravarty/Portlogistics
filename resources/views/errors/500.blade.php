@extends('layouts.layout')

@section('title')

<title>Something Went Wrong</title>

@endsection

@section('content')
  <div class="container">
    <img src="https://i.imgur.com/qIufhof.png" height=250 width=250 alt=""/>
    <br>
    <h1>
      <span><strong>500</strong></span><br/>
    </h1>
    <h2>
      Oops! Something went wrong..
    </h2>
    <p>We are currently trying to fix the problem.</p>
    <a href="{{route('home')}}">Go back</a>
  </div>
@endsection

@push('style')
<style>
    @import url("https://fonts.googleapis.com/css?family=Fira+Code&display=swap");

* {
  margin: 0;
  padding: 0;
}
h1{
    color: maroon;
}
span{
  font-size: 80px;
}
body {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #ecf0f1;
  margin-left:100px;
}

.container {
  text-align: center;
  margin: auto;
  padding: 4em;
  img {
    width: 256px;
    height: 225px;
  }

  h1 {
    font-weight: 700;
    margin-top: 1rem;
    font-size: 40px;
    text-align: center;
  }
  p {
    margin-top: 1rem;
    font-family: cursive;
  }
  a {
    color: white;
    text-decoration: none;
    text-transform: uppercase;
    &:hover {
      color: lightgray;
    }
	}
}
</style>
@endpush