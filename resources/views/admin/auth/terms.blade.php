@extends('limitless.login')
@section('title', 'PSK::Register')
@section('content')
<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel registration-form">
            {!! Form::open(array('route' => 'auth.register.attempt','role'=>"form",'files'=>true,'mutipart')) !!}
                <input name="_token" value="{{ csrf_token() }}" type="hidden">
                <div class="panel-body">
                    <div class="text-center">
                        <h5><b>Terms & Conditions</b></h5>
                        <p class="text-justify">
                        1. You must follow any policies made available to you within the Services.
                        <br><br>

                        2. Don’t misuse our Services. For example, don’t interfere with our Services or try to access them using a method other than the interface and the instructions that we provide. You may use our Services only as permitted by law, including applicable export and re-export control laws and regulations. We may suspend or stop providing our Services to you if you do not comply with our terms or policies or if we are investigating suspected misconduct.

                        <br><br>
                        3. Using our Services does not give you ownership of any intellectual property rights in our Services or the content you access. You may not use content from our Services unless you obtain permission from its owner or are otherwise permitted by law. These terms do not grant you the right to use any branding or logos used in our Services. Don’t remove, obscure, or alter any legal notices displayed in or along with our Services.

                        <br><br>
                        4. Our Services display some content that is not Google’s. This content is the sole responsibility of the entity that makes it available. We may review content to determine whether it is illegal or violates our policies, and we may remove or refuse to display content that we reasonably believe violates our policies or the law. But that does not necessarily mean that we review content, so please don’t assume that we do.

                        <br><br>

                        5. In connection with your use of the Services, we may send you service announcements, administrative messages, and other information. You may opt out of some of those communications.

                        <br><br>
                        6. Some of our Services are available on mobile devices. Do not use such Services in a way that distracts you and prevents you from obeying traffic or safety laws.

                        <br><br>
                        7. Some of our Services allow you to upload, submit, store, send or receive content. You retain ownership of any intellectual property rights that you hold in that content. In short, what belongs to you stays yours.

                        <br><br>
                        8. When you upload, submit, store, send or receive content to or through our Services, you give Google (and those we work with) a worldwide license to use, host, store, reproduce, modify, create derivative works (such as those resulting from translations, adaptations or other changes we make so that your content works better with our Services), communicate, publish, publicly perform, publicly display and distribute such content.

                        <br><br>
                        9. The rights you grant in this license are for the limited purpose of operating, promoting, and improving our Services, and to develop new ones. This license continues even if you stop using our Services (for example, for a business listing you have added to Google Maps). Some Services may offer you ways to access and remove content that has been provided to that Service. Also, in some of our Services, there are terms or settings that narrow the scope of our use of the content submitted in those Services. Make sure you have the necessary rights to grant us this license for any content that you submit to our Services.
                        </p>
                        <br>
                        <hr>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
