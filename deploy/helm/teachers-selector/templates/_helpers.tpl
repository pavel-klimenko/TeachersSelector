{{- define "ts.fullname" -}}
{{- printf "%s" .Release.Name | trunc 40 | trimSuffix "-" -}}
{{- end -}}

{{- define "ts.labels" -}}
app.kubernetes.io/name: teachers-selector
app.kubernetes.io/instance: {{ .Release.Name }}
app.kubernetes.io/managed-by: {{ .Release.Service }}
helm.sh/chart: {{ .Chart.Name }}-{{ .Chart.Version }}
{{- end -}}

{{- define "ts.selector" -}}
app.kubernetes.io/name: teachers-selector
app.kubernetes.io/instance: {{ .root.Release.Name }}
app.kubernetes.io/component: {{ .component }}
{{- end -}}

{{- define "ts.secretName" -}}
{{- if .Values.secrets.existingSecret -}}{{ .Values.secrets.existingSecret }}{{- else -}}{{ include "ts.fullname" . }}{{- end -}}
{{- end -}}

{{- define "ts.phpImage" -}}
{{ .Values.image.php.repository }}:{{ .Values.image.php.tag }}
{{- end -}}

{{- define "ts.envFrom" -}}
- configMapRef:
    name: {{ include "ts.fullname" . }}
- secretRef:
    name: {{ include "ts.secretName" . }}
{{- end -}}

{{- define "ts.pullSecrets" -}}
{{- with .Values.image.pullSecrets }}
imagePullSecrets:
{{- toYaml . | nindent 2 }}
{{- end }}
{{- end -}}
