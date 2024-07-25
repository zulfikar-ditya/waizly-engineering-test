<?php

test('can get list of article tags', function () {
    $response = $this
        ->getJson(route('client.article-tag.index'));

    $response->assertStatus(200);
});
