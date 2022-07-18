<?php

namespace Typesense\LaravelTypesense\Traits;

use Typesense\LaravelTypesense\Typesense;
use Typesense\LaravelTypesense\Engines\TypesenseEngine;
use Laravel\Scout\Searchable;

trait Typesenseable {
  use Searchable;

  public function updateTypesenseSchema(array $schema)
  {
      $typesense = resolve(Typesense::class);
      $typesense->updateModelCollectionSchema($this, $schema);
  }

  public function scopeSearchBy($builder, string $query, array $options = [])
  {
    $engine = resolve(TypesenseEngine::class);
    return $builder->whereIn('id', $engine->mapIds($engine->searchCustom($this, $query, $options)));
  }
}
