<script type='application/ld+json'>
        {
          "@context": "http://schema.org",
          "@type": "Article",
          "@id": "{{isset($page) ? $page->code : 'content'}}",
          "author": {
            "@type": "Person",
            "name": "deconf"
          },
          "dateModified": "{{\Carbon::now()->sub('1 hour')}}",
          "datePublished": "{{$page->created_at}}",
          "headline": "{{isset($page) ? $page->header : 'military'}}",
          "url": "{{request()->url()}}",
          "commentCount": {{count($comments ?? [])}},
          "keywords": "php, laravel, military, illuminate",

        "articleBody": "{{isset($page) ? $page->content : ''}}",
          "description": "{{isset($page) ? $page->description : ''}}",
          "publisher": {
            "@type": "Organization",
            "name": "axis9",
            "logo": {
              "@type": "ImageObject",
              "url": "/logo.png"
            },
            "url": "http://kilitary.ru"
          },
          "image": "/logo.png"
        }


</script>
