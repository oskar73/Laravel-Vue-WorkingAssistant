
@foreach($posts as $num => $post)
    <tr>
        <td>{{($page - 1) * 100 + $num + 1}}</td>
        <td><input type="checkbox" class="checkbox" data-id="{{$post['id']}}"></td>
        <td><div class="blog-category" data-id="{{$post['categories'][0] ?? ''}}"></div></td>
        <td><a href="{{ $post['link'] }}" target="_blank">{{mb_convert_encoding($post['title']['rendered'], 'UTF-8', 'HTML-ENTITIES')}}</a></td>
        <td><div class="blog-tag" data-ids="{{ join(',', $post['tags'] ?? []) }}"></div></td>
        <td><div class="blog-author" data-id="{{ $post['author'] }}"></div></td>
    </tr>
@endforeach
