@php
    echo '<?xml version="1.0" encoding="UTF-8"?>';

    $currentDate = time();
@endphp

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        {{-- <lastmod>{{date('Y-m-d H:i:s')}}</lastmod> --}}
        <lastmod>{{date('c', $currentDate)}}</lastmod>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/sitemap_sitemap/postcodes</loc>
        {{-- <lastmod>{{date('Y-m-d H:i:s')}}</lastmod> --}}
        <lastmod>{{date('c', $currentDate)}}</lastmod>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/sitemap_sitemap/suburbs</loc>
        {{-- <lastmod>{{date('Y-m-d H:i:s')}}</lastmod> --}}
        <lastmod>{{date('c', $currentDate)}}</lastmod>
        <priority>0.8</priority>
    </url>

    @for ($i = 0; $i < $totalDirectoryPages; $i++)
    <url>
        <loc>{{ url('/') }}/sitemap_sitemap/directory{{$i + 1}}</loc>
        {{-- <lastmod>{{date('Y-m-d H:i:s')}}</lastmod> --}}
        <lastmod>{{date('c', $currentDate)}}</lastmod>
        <priority>0.8</priority>
    </url>
    @endfor

    <url>
        <loc>{{ url('/') }}/sitemap_sitemap/articlecategory</loc>
        {{-- <lastmod>{{date('Y-m-d H:i:s')}}</lastmod> --}}
        <lastmod>{{date('c', $currentDate)}}</lastmod>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/sitemap_sitemap/articles</loc>
        {{-- <lastmod>{{date('Y-m-d H:i:s')}}</lastmod> --}}
        <lastmod>{{date('c', $currentDate)}}</lastmod>
        <priority>0.8</priority>
    </url>

</urlset>



{{-- <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($data as $item)
        @php
            $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item['created_at'], 'Australia/Melbourne');
            $showDate = $date->setTimezone('UTC');
        @endphp

        <url>

            @if ($type == "directory")
                <loc>{{ url('/') }}/directory/{{ $item['slug'] }}</loc>
            @elseif ($type == "articlecategory")
                <loc>{{ url('/') }}/article/category/{{ $item['slug'] }}</loc>
            @elseif ($type == "article")
                <loc>{{ url('/') }}/article/{{ $item['slug'] }}</loc>
            @elseif ($type == "postcode")
                <loc>{{ url('/') }}/postcode/{{ $item['pin'] }}</loc>
            @elseif ($type == "suburb")
                <loc>{{ url('/') }}/suburb/{{ $item['slug'] }}</loc>
            @endif

            <lastmod>{{$showDate}}</lastmod>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset> --}}