@props(['category', 'icon'])
<div class="category-item">
    <a href="/categories/{{$category->id}}">
        <i class="fa-solid {{$icon}}"></i>
        <p>{{$category->name}}</p>
    </a>
</div>