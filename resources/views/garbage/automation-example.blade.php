<div class="modal fade" id="automation-example-modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Automation Example</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="{{ Str::title(__('common.close')) }}">
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <h3>Automation Example</h3>
                    </div>
                    <div class="card-body">
                        The example below can be used to send a notification using the <code>notify.notify</code>
                        service to one or more devices the day before collection @ 18:00.<br>
                        Change <code>sensor.dagrenovation</code> to match the sensor entity you want to base the notification on.<br>

                        <pre class="bg-dark text-light p-2 rounded-3 m-0 mt-2">alias: Notifikation - Tømning af affaldscontainer
description: Garbage notification based on https://api.harders-it.dk/garbage
trigger:
  - platform: time
    at: '18:00'
condition:
  - condition: state
    entity_id: sensor.dagrenovation
    state: tomorrow
    attribute: state
action:
  - service: notify.notify
    data:
      message: >-
        Afhentning af @{{ state_attr('sensor.dagrenovation', 'service') | lower }} @{{ states('sensor.dagrenovation') }}
      title: >-
        @{{ state_attr('sensor.dagrenovation', 'service') }}
      data:
        notification_icon: mdi:trash-can-outline
mode: single
</pre>
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
