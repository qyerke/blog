@extends('layout')


@section('content')
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                      <article class="post">
                    <div class="post-thumb">
                        <a href="blog.html"><img src="{{ $post->getImage() }}" alt=""></a>
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <h6><a href="{{$post->getCategorySlug()}}"> {{$post->getCategoryTitle()}}</a></h6>

                            <h1 class="entry-title"><a href="blog.html">{{$post->title}}</a></h1>


                        </header>
                        <div class="entry-content">
							                   {!!$post->content!!}
                        </div>
                        <div class="decoration">
                            <a href="#" class="btn btn-default">Decoration</a>
                            <a href="#" class="btn btn-default">Decoration</a>
                        </div>

                        <div class="social-share">
							<span class="social-share-title pull-left text-capitalize">By {{$post->author->name}} On </span>
                            <ul class="text-center pull-right">
                                <li><a class="s-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a class="s-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a class="s-google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a class="s-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a class="s-instagram" href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </article>
                <div class="top-comment"><!--top comment-->
                    <img src="{{ $post->author->getAvatar() }}" class="pull-left img-circle" width="120px" height="100px" alt="">
                    <h4>{{$post->author->name}}</h4>

                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy hello ro mod tempor
                        invidunt ut labore et dolore magna aliquyam erat.</p>
                </div><!--top comment end-->
                <div class="row"><!--blog next previous-->
                	@if($post->hasPrevious())
                    <div class="col-md-6">
                        <div class="single-blog-box">
                            <a href="{{route('post.show', $post->getPrevious()->slug)}}">
                                <img src="{{ $post->getPrevious()->getImage() }}" alt="">
                                <div class="overlay">
                                    <div class="promo-text">
                                        <p><i class=" pull-left fa fa-angle-left"></i></p>
                                        <h5>{{$post->getPrevious()->title}}</h5>
                                    </div>
                                </div>


                            </a>
                        </div>
                  	</div>
					@endif
                    <div class="col-md-6">
                    @if($post->hasNext($post))
                        <div class="single-blog-box">
                            <a href="{{$post->getNext()->slug}}">
                                <img src="{{$post->getNext()->getImage()}}" alt="">
                                <div class="overlay">
                                    <div class="promo-text">
                                        <p><i class=" pull-right fa fa-angle-right"></i></p>
                                        <h5>Rubel is doing Cherry theme</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    </div>
                </div><!--blog next previous end-->
                <div class="related-post-carousel"><!--related post carousel-->
                    <div class="related-heading">
                        <h4>You might also like</h4>
                    </div>
                    <div class="items">
                        <div class="single-item">
                            <a href="#">
                                <img src="/images/related-post-1.jpg" alt="">

                                <p>Just Wondering at Beach</p>
                            </a>
                        </div>


                        <div class="single-item">
                            <a href="#">
                                <img src="/images/related-post-2.jpg" alt="">

                                <p>Just Wondering at Beach</p>
                            </a>
                        </div>


                        <div class="single-item">
                            <a href="#">
                                <img src="/images/related-post-3.jpg" alt="">

                                <p>Just Wondering at Beach</p>
                            </a>
                        </div>


                        <div class="single-item">
                            <a href="#">
                                <img src="/images/related-post-1.jpg" alt="">

                                <p>Just Wondering at Beach</p>
                            </a>
                        </div>

                        <div class="single-item">
                            <a href="#">
                                <img src="/images/related-post-2.jpg" alt="">

                                <p>Just Wondering at Beach</p>
                            </a>
                        </div>


                        <div class="single-item">
                            <a href="#">
                                <img src="/images/related-post-3.jpg" alt="">

                                <p>Just Wondering at Beach</p>
                            </a>
                        </div>
                    </div>
                </div><!--related post carousel-->
                @if(!$post->comments->isEmpty())
                @foreach($post->getComments() as $comment)
                <div class="bottom-comment"><!--bottom comment-->
                  <div class="comment-img">
                        <img class="img-circle" width="75px" height="75px" src="{{ $comment->author->getAvatar() }}" alt="">
                    </div>

                    <div class="comment-text">
                        <h5>{{$comment->author->name}}</h5>
                        <p class="comment-date">
                            {{$comment->created_at->diffForHumans()}}
                        </p>
                        <p class="para">{{$comment->text}}</p>
                    </div>
                </div>
                <!-- end bottom comment-->
                @endforeach
                @endif


                @if(Auth::check())
                <div class="leave-comment"><!--leave comment-->
                    <h4>Leave a reply</h4>

                    <form class="form-horizontal contact-form" role="form" method="post" action="/comment">
                        {{csrf_field()}}
                        <div class="form-group">
                            <div class="col-md-12">
                              <input type="hidden" name="post_id" value="{{$post->id}}">
										            <textarea class="form-control" rows="6" name="message" placeholder="Write Massage">
                                </textarea>
                            </div>
                        </div>
                        <button class="btn send-btn">Post Comment</button>
                    </form>
                </div><!--end leave comment-->
                @endif
            </div>
            @include('pages._sidebar')
            </div>
        </div>
    </div>
</div>
@endsection
