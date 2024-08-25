<?php

declare(strict_types=1);

use CuyZ\Valinor\Library\Settings;
use CuyZ\Valinor\MapperBuilder;

describe('mapper builder', function () {
    it('resolves a mapper builder with the default supported datetime formats', function () {
        /** @var MapperBuilder $builder */
        $builder = resolve(MapperBuilder::class);
        expect(value: $builder->supportedDateFormats())
            ->toBe(Settings::DEFAULT_SUPPORTED_DATETIME_FORMATS);
    });

    it('resolves a mapper builder with supported datetime formats', function () {
        config()->set('valinor.supported_date_formats', [DATE_ATOM, DATE_COOKIE]);

        /** @var MapperBuilder $builder */
        $builder = resolve(MapperBuilder::class);
        expect(value: $builder->supportedDateFormats())
            ->toBe([DATE_ATOM, DATE_COOKIE]);
    });
});
