<div class="modal fade" id="help-modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Help</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="{{ Str::title(__('common.close')) }}">
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <h3>Installation</h3>
                    </div>
                    <div class="card-body">
                        <ol>
                            <li>
                                Copy the sensor YAML
                            </li>
                            <li>
                                Place it in your configuration.yaml under the <code>sensor</code> directive
                                <pre class="bg-dark text-light p-2 rounded-3 m-0">sensor:<br>- platform: rest<br>  name: ...</pre>
                            </li>
                            <li>
                                Reload your REST entities or restart Home Assitant
                            </li>
                            <li>
                                The sensor(s) should now be ready for use.
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-header">
                        <h3>Pro Tip</h3>
                    </div>
                    <div class="card-body">
                        If you're adding multiple sensors to the <code>sensor</code> directive in the root of the
                        configuration.yaml file, then you'd probably want to group the sensors into individual files.

                        <ol>
                            <li>
                                Create a directory called 'sensors' in the root of your Home Assistant configuration
                                directory
                            </li>
                            <li>
                                Add the following to the <code>sensor</code> directive in your configuration.yaml file:
                                <pre
                                    class="bg-dark text-light p-2 rounded-3 m-0">sensor: !include_dir_merge_list sensors/</pre>
                                This tells Home Assistant to merge all YAML files within the 'sensors' directory and
                                apply the resulting YAML to the <code>sensor</code> directive.
                            </li>
                            <li>
                                Create a file in the 'sensors' directory called 'garbage.yaml'
                                @if($garbage)
                                    (or download it <a href="{{ route('garbage.download', ['address' => request('address'), 'type' => 'yaml', 'lang' => App::getLocale()]) }}">
                                        here
                                    </a>)
                                @endif
                            </li>
                            <li>
                                Paste the copied YAML from the installation section to the 'garbage.yaml' file and
                                restart your Home Assistant.
                                @if($garbage)
                                    <br>(if you downloaded the file from above then just move the file into the `sensors` directory)
                                @endif
                            </li>
                            <li>
                                The sensor(s) should now be ready for use.
                            </li>
                        </ol>
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
