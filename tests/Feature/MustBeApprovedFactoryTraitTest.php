<?php

use Cjmellor\Approval\Tests\Models\FakeModel;

test(description: 'a model is added via a factory when the "withoutApproval()" method is used ', closure: function () {
    FakeModel::factory()->withoutApproval()->create();

    $this->assertDatabaseHas('fake_models', [
        'name' => 'Bob',
        'meta' => 'green',
    ]);

    $this->assertDatabaseMissing('approvals', [
        'new_data' => json_encode([
            'name' => 'Bob',
        ]),
    ]);
});

test(description: 'many models are added via a factory when the "withoutApproval()" method is used ', closure: function () {
    FakeModel::factory()->withoutApproval()->count(4)->create();

    $this->assertCount(4, FakeModel::all());

    FakeModel::all()->each(function ($model) {
        $this->assertEquals('Bob', $model->name);
        $this->assertEquals('green', $model->meta);
    });

    $this->assertDatabaseMissing('approvals', [
        'new_data' => json_encode([
            'name' => 'Bob',
        ]),
    ]);
});
