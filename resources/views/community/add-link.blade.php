@if(Auth::check())
<div class="col-md-4">
    <h3>Contribute a link</h3>
    <div class="panel panel-default">
        <div class="panel-body">
            <form method="post" action="/community" class="form-horizontal">
            {{csrf_field()}}
                <div class="form-group">
                    <label for="channel">Channel</label>
                    <select name="channel_id" class="form-control">
                        <option selected disabled>Pick a channel</option>
                        @foreach($channels as $channel)
                            <option @if(old('channel_id') == $channel->id) selected @endif value="{{$channel->id}}">{{$channel->title}}</option>
                        @endforeach
                    </select>
                    {!!$errors->first('channel_id', '<span class="Error">:message</span>')!!}
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input required id="title" name="title" class="form-control" type="text" placeholder="What is the title of your article" value="{{old('title')}}" />
                    {!!$errors->first('title', '<span class="Error">:message</span>')!!}
                </div>
                <div class="form-group">
                    <label for="link">Link</label>
                    <input required id="link" name="link" class="form-control" type="text" placeholder="What is the link of your article" value="{{old('link')}}" />
                    {!!$errors->first('link', '<span class="Error">:message</span>')!!}
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Contribute Link</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif