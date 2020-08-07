import {AuthConfig} from 'angular-oauth2-oidc';

import {environment} from '../environments/environment';

export const passwordFlowConfig: AuthConfig = {
  tokenEndpoint: environment.authUrl + '/oauth/auth',
  revocationEndpoint: environment.authUrl + '/oauth/logout',
  userinfoEndpoint: environment.authUrl + '/auth/profile',
  clientId: environment.clientId,
  dummyClientSecret: environment.clientSecret,
  useSilentRefresh: true,
  scope: "",
  requireHttps: false,
  showDebugInformation: true,
  oidc: false,
};
