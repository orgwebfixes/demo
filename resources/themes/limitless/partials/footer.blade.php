<div class="footer text-muted">
	<div class="col-sm-6">
		&copy; {{ date('Y') }}.
		<a href="{{ route('dashboard') }} ">
			{{Config::get('srtpl.settings.site_copyright','orgwebtech.com')}}
		</a>
	</div>
	<div class="col-sm-6">
		<span class="float-right">
			Crafted With <i class="fa fa-heart text-danger"></i> By <a target="_blank"
				href="{{ Config::get('constants.COMPANY_LINK') }}">
				{{ Config::get('constants.COMPANY_NAME','ORG WebTech.') }}
			</a>
		</span>
	</div>
</div>