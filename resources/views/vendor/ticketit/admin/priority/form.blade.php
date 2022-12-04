<div class="form-group">
    {!! CollectiveForm::label('name', trans('ticketit::admin.priority-create-name') . trans('ticketit::admin.colon'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! CollectiveForm::text('name', isset($priority->name) ? $priority->name : null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! CollectiveForm::label('color', trans('ticketit::admin.priority-create-color') . trans('ticketit::admin.colon'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! CollectiveForm::custom('color', 'color', isset($priority->color) ? $priority->color : "#000000", ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-lg-10 col-lg-offset-2">
        {!! link_to_route($setting->grab('admin_route').'.priority.index', trans('ticketit::admin.btn-back'), null, ['class' => 'btn btn-default']) !!}
        @if(isset($priority))
            {!! CollectiveForm::submit(trans('ticketit::admin.btn-update'), ['class' => 'btn btn-primary']) !!}
        @else
            {!! CollectiveForm::submit(trans('ticketit::admin.btn-submit'), ['class' => 'btn btn-primary']) !!}
        @endif
    </div>
</div>
