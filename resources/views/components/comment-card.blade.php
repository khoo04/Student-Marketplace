@props(['comment'])
<div class="comment-card">
    <h3>{{$comment->user->first_name . ' ' . $comment->user->last_name}}</h3>
    <div class="rating">
        <div class="stars-outer">
            <div class="stars-inner" style="width:{{round((($comment->rating/5) * 100) / 10) * 10}}%"></div>
        </div>
    </div>
    <p class="comment">{{$comment->description}}</p>
    <p class="date">
        {{$comment->created_at->format('d/m/Y H:i')}}
    </p>
</div>