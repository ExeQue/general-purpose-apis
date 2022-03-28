<div class="modal fade" id="schema-modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">
                    Schema for <code>json_attributes</code>
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="{{ Str::title(__('common.close')) }}">
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                <tr>
                                    <th>{{ Str::title(__('common.field')) }}</th>
                                    <th>{{ Str::title(__('common.type')) }}</th>
                                    <th>{{ Str::title(__('common.description')) }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>name</td>
                                    <td><code>text</code></td>
                                    <td>@lang('garbage.descriptions.fields.name')</td>
                                </tr>
                                <tr>
                                    <td>title</td>
                                    <td><code>text</code></td>
                                    <td>@lang('garbage.descriptions.fields.title')</td>
                                </tr>
                                <tr>
                                    <td>address_long</td>
                                    <td><code>text</code></td>
                                    <td>@lang('garbage.descriptions.fields.address_long')</td>
                                </tr>
                                <tr>
                                    <td>address_short</td>
                                    <td><code>text</code></td>
                                    <td>@lang('garbage.descriptions.fields.address_short')</td>
                                </tr>
                                <tr>
                                    <td>service</td>
                                    <td><code>text</code></td>
                                    <td>@lang('garbage.descriptions.fields.service')</td>
                                </tr>
                                <tr>
                                    <td>state</td>
                                    <td><code>text</code></td>
                                    <td>@lang('garbage.descriptions.fields.state')</td>
                                </tr>
                                <tr>
                                    <td>next_date</td>
                                    <td><code>text</code></td>
                                    <td>@lang('garbage.descriptions.fields.next_date')</td>
                                </tr>
                                <tr>
                                    <td>next_local</td>
                                    <td><code>text</code></td>
                                    <td>@lang('garbage.descriptions.fields.next_local')</td>
                                </tr>
                                <tr>
                                    <td>next_day_long</td>
                                    <td><code>text</code></td>
                                    <td>@lang('garbage.descriptions.fields.next_day_long')</td>
                                </tr>
                                <tr>
                                    <td>next_day_short</td>
                                    <td><code>text</code></td>
                                    <td>@lang('garbage.descriptions.fields.next_day_short')</td>
                                </tr>
                                <tr>
                                    <td>next_day_min</td>
                                    <td><code>text</code></td>
                                    <td>@lang('garbage.descriptions.fields.next_day_min')</td>
                                </tr>
                                <tr>
                                    <td>next_in_days</td>
                                    <td><code>number</code></td>
                                    <td>@lang('garbage.descriptions.fields.next_in_days')</td>
                                </tr>
                                <tr>
                                    <td>next_in_weeks</td>
                                    <td><code>number</code></td>
                                    <td>@lang('garbage.descriptions.fields.next_in_weeks')</td>
                                </tr>
                                <tr>
                                    <td>next_in_months</td>
                                    <td><code>number</code></td>
                                    <td>@lang('garbage.descriptions.fields.next_in_months')</td>
                                </tr>
                                <tr>
                                    <td>next_in_human</td>
                                    <td><code>text</code></td>
                                    <td>@lang('garbage.descriptions.fields.next_in_human')</td>
                                </tr>
                                <tr>
                                    <td>next_is_today</td>
                                    <td><code>bool</code></td>
                                    <td>@lang('garbage.descriptions.fields.next_is_today')</td>
                                </tr>
                                <tr>
                                    <td>next_is_tomorrow</td>
                                    <td><code>bool</code></td>
                                    <td>@lang('garbage.descriptions.fields.next_is_tomorrow')</td>
                                </tr>
                                <tr>
                                    <td>next_is_this_week</td>
                                    <td><code>bool</code></td>
                                    <td>@lang('garbage.descriptions.fields.next_is_this_week')</td>
                                </tr>
                                <tr>
                                    <td>next_is_this_month</td>
                                    <td><code>bool</code></td>
                                    <td>@lang('garbage.descriptions.fields.next_is_this_month')</td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3">
                                        <small>
                                            Everything is localized as much as possible and dependent on the selected
                                            <code>lang</code> in the request URL
                                        </small>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ Str::title(__('common.close')) }}
                </button>
            </div>
        </div>
    </div>
</div>

