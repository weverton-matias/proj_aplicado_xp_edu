import { ThemeProvider } from '@automattic/jetpack-components';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import * as WPElement from '@wordpress/element';
import { HashRouter } from 'react-router';
import { AutomationsAdmin } from '.';

/**
 * Render function
 */
const render = () => {
	const queryClient = new QueryClient();

	const container = document.getElementById( 'jetpack-crm-automations-root' );

	if ( null === container ) {
		return;
	}

	const component = (
		<HashRouter>
			<ThemeProvider>
				<QueryClientProvider client={ queryClient }>
					<AutomationsAdmin />
				</QueryClientProvider>
			</ThemeProvider>
		</HashRouter>
	);

	WPElement.createRoot( container ).render( component );
};

render();
