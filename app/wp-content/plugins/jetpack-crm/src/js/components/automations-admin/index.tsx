import { Col, Container } from '@automattic/jetpack-components';
import { __ } from '@wordpress/i18n';
import { Routes, Route } from 'react-router';
import AdminPage from 'crm/components/admin-page';
import { RedirectHome } from './components/redirect-home';
import { WorkflowsHome } from './components/workflows-home';

export const AutomationsAdmin = () => {
	return (
		<Routes>
			<Route
				path="/automations/:id?"
				element={
					<AdminPage
						headline={ __( 'Automations', 'zero-bs-crm' ) }
						subHeadline={ __( 'Streamline your workflows with CRM Automations', 'zero-bs-crm' ) }
					>
						<Container>
							<Col>
								<WorkflowsHome />
							</Col>
						</Container>
					</AdminPage>
				}
			/>
			<Route path="*" element={ <RedirectHome /> } />
		</Routes>
	);
};
