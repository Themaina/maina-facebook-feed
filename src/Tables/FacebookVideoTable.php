<?php

namespace Maina888\FacebookFeed\Tables;

use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\CreatedAtBulkChange;
use Botble\Table\BulkChanges\StatusBulkChange;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\ImageColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Maina888\FacebookFeed\Models\FacebookVideo;
use Illuminate\Database\Eloquent\Builder;

class FacebookVideoTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(FacebookVideo::class)
            ->addColumns([
                IdColumn::make(),
                ImageColumn::make('cover_image')
                    ->title(trans('plugins/facebook-feed::facebook-feed.cover_image')),
                NameColumn::make('title')
                    ->title(trans('plugins/facebook-feed::facebook-feed.title'))
                    ->route('facebook-feed.edit'),
                FormattedColumn::make('video_url')
                    ->title(trans('plugins/facebook-feed::facebook-feed.video_url'))
                    ->limit(60),
                Column::make('order')
                    ->title(trans('plugins/facebook-feed::facebook-feed.order'))
                    ->width(80),
                StatusColumn::make(),
                CreatedAtColumn::make(),
            ])
            ->addHeaderAction(CreateHeaderAction::make()->route('facebook-feed.create'))
            ->addActions([
                EditAction::make()->route('facebook-feed.edit'),
                DeleteAction::make()->route('facebook-feed.destroy'),
            ])
            ->addBulkAction(DeleteBulkAction::make()->permission('facebook-feed.destroy'))
            ->addBulkChanges([
                StatusBulkChange::make(),
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                return $query
                    ->select([
                        'id',
                        'title',
                        'video_url',
                        'cover_image',
                        'status',
                        'created_at',
                        'order',
                    ])
                    ->orderBy('order')
                    ->orderByDesc('id');
            });
    }
}
