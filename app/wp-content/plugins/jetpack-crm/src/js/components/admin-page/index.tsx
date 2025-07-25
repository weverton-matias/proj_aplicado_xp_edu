import {
	AdminPage as JetpackAdminPage,
	AdminSectionHero,
	Col,
	Container,
	Text,
} from '@automattic/jetpack-components';
import styles from './styles.module.scss';
import type { AdminPageProps } from './types';
import type { FC, ReactNode } from 'react';

/**
 * This is the base structure for any Jetpack CRM admin page.
 *
 * All content must be passed as children wrapped in as many <AdminSection> elements as needed.
 *
 * @param {AdminPageProps} props - Component properties.
 * @return {ReactNode} AdminPage component.
 */
const AdminPage: FC< AdminPageProps > = props => {
	const pageProps = {
		/*
		 * Hide footer and header since we output them with PHP.
		 */
		showHeader: false,
		showFooter: false,
		showBackground: false,
		...props,
	};
	const { children, headline, subHeadline } = props;

	return (
		<div className={ styles[ 'admin-page' ] }>
			<JetpackAdminPage { ...pageProps }>
				<AdminSectionHero>
					{ ( headline || subHeadline ) && (
						<Container horizontalSpacing={ 5 }>
							<Col>
								{ headline && <Text variant="headline-small">{ headline }</Text> }
								{ subHeadline && (
									<Text className={ styles[ 'sub-headline' ] } variant="body-small">
										{ subHeadline }
									</Text>
								) }
							</Col>
						</Container>
					) }
				</AdminSectionHero>
				{ children }
			</JetpackAdminPage>
		</div>
	);
};

export default AdminPage;
