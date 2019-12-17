FROM kibana:4.4

RUN kibana plugin --install elastic/sense \
	&& chown kibana:kibana /opt/kibana/optimize/.babelcache.json
