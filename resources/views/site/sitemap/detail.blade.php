@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($data as $item)
        @if (!empty($item['created_at']))
            @php
                $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item['created_at'], 'Australia/Melbourne');
                $showDate = $date->setTimezone('UTC');
                $currentDate = time();
            @endphp
        @else
            @php
                $showDate = date('Y-m-d H:i:s');
                $currentDate = time();
            @endphp
        @endif

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
            @elseif ($type == "collection")
                <loc>{{ url('/') }}/collection/{{ $item['slug'] }}</loc>
            @endif

            <lastmod>{{date('c', $currentDate)}}</lastmod>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>