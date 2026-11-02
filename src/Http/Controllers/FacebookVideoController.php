<?php

namespace Maina888\FacebookFeed\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Supports\Breadcrumb;
use Maina888\FacebookFeed\Forms\FacebookVideoForm;
use Maina888\FacebookFeed\Http\Requests\FacebookVideoRequest;
use Maina888\FacebookFeed\Models\FacebookVideo;
use Maina888\FacebookFeed\Tables\FacebookVideoTable;

class FacebookVideoController extends BaseController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('plugins/facebook-feed::facebook-feed.name'), route('facebook-feed.index'));
    }

    public function index(FacebookVideoTable $table)
    {
        $this->pageTitle(trans('plugins/facebook-feed::facebook-feed.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/facebook-feed::facebook-feed.create'));

        return FacebookVideoForm::create()->renderForm();
    }

    public function store(FacebookVideoRequest $request)
    {
        $form = FacebookVideoForm::create()->setRequest($request);
        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousRoute('facebook-feed.index')
            ->setNextRoute('facebook-feed.edit', $form->getModel()->getKey())
            ->withCreatedSuccessMessage();
    }

    public function edit(FacebookVideo $video)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $video->title ?: $video->video_url]));

        return FacebookVideoForm::createFromModel($video)->renderForm();
    }

    public function update(FacebookVideo $video, FacebookVideoRequest $request)
    {
        FacebookVideoForm::createFromModel($video)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousRoute('facebook-feed.index')
            ->withUpdatedSuccessMessage();
    }

    public function destroy(FacebookVideo $video)
    {
        return DeleteResourceAction::make($video);
    }
}
